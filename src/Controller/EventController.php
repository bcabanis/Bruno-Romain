<?php

namespace App\Controller;

use App\Document\Events;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Document\ChatMessage;
use App\Service\NewApiService;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\ChatMessageRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/affichage', name: 'app_event_affichage')] // Affichage de tous les événements de la BDD (pas API)
    
    public function AfficheEvent(EventRepository $eventRepository, CacheInterface $cache, DocumentManager $dm): Response
    {

        $dataTabForJs = $cache->get('events_cache', function ($item) use ($eventRepository) {
            
                $events = $eventRepository->findAll();
                $dataTabForJs = [];

                foreach ($events as $event) {
                $dataForJs = [
                    'title' => $event->getTitle(),
                    'description' => $event->getDescription(),
                    'adresse' => $event->getAddress(),
                    'image' => $event->getImageUrl(),
                    'unique_id' => $event->getEventId(),
                    'dateFormat' => $event->getDateFormat(),
                    'category' => $event->getCategory(),
                                ];
                    $dataTabForJs[] = $dataForJs;
                                        }
            return $dataTabForJs;
    }); 
        return $this->render('event/affichage.html.twig', [
            'jsonData' => $dataTabForJs,
        ]);
    }

    #[Route('/affichage2', name: 'app_event_affichage2')] // Affichage des events de l'API
    public function AfficheEvent2(NewApiService $newApi, CacheInterface $cache): Response
    {
        $data = $newApi->getDatas();
        
        return $this->render('event/affichage2.html.twig', [
            'data' => $data,
            ]);
    }

    // #[Route('/search', name: 'app_event_search', methods: ['GET'])] // Barre de recherche Dashboard
    // public function searchEvent(NewApiService $newApi, Request $request): Response
    // {
    //     $datas = $newApi->getDatas();
    //     $filteredEvent = ;

    //     foreach ($datas as $data) {
    //         if (!$request) {
    //             return $this->render('event/error.html.twig', [], new Response('', 404));
    //             }
            
    //     }



    //     return $this->render('event/affichage2.html.twig', [
    //         'data' => $data,
    //         ]);
    // }

    // #[Route('/search', name: 'app_event_search', methods: ['GET'])] // Barre de recherche Dashboard
    // public function searchEvent(EventRepository $eventRepository, Request $request): Response
    // {
    //     $searchData = new SearchData();
    //     $form = $this->createForm(SearchType::class, $searchData);

    //     $form->handleRequest($request);
    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         dd($searchData);
    //     }
    //     return $this->render('pages/post/index.html.twig', [
    //         'form' => $form->createView(),
    //         'posts' => $eventRepository->findPublished($request->query->getInt('page', 1))
    //     ]);
    // }


    #[Route('/{eventUid}', name: 'app_event_show')]
    public function show(ChatMessageRepository $chatMessageRepository, string $eventUid, SessionInterface $sessionInterface, NewApiService $newApi): Response
    {
        $event = $newApi->getDataById($eventUid);
        
        if (!$event) {
        return $this->render('event/error.html.twig', [], new Response('', 404));
        }

        // Récupère les messages de chat associés à l'événement
        $chatMessages = $chatMessageRepository->findBy(['eventId' => $eventUid]);
        // Récupère l'email de l'utilisateur connecté depuis la session
        $emailSession = $sessionInterface->get('email');

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'chatMessages' => $chatMessages,
            'email' => $emailSession,
            'parentId' => null // Pour le premier niveau de messages, parentId est nul
        ]);
    }

    #[Route('/{eventUid}/post_chat_message', name: 'app_event_post_chat_message', methods: ['GET', 'POST'])]
    public function postChatMessage(Request $request, UserRepository $userRepository, ChatMessageRepository $chatMessageRepository, string $eventUid, SessionInterface $session, NewApiService $newApi): Response
    {
        $emailSession = $session->get('email');
        $authenticatedUser = $userRepository->findOneBy(['email' => $emailSession]);
        $event = $newApi->getDataById($eventUid);

        if (!$event) {
            throw $this->createNotFoundException('Aucun évènement trouvé.');
        }

        $messageContent = $request->request->get('content');

        if ($messageContent === null) {
            $messageContent = ''; 
        }

        // Récupérer l'ID du message parent (s'il y en a un)
        $parentMessageId = $request->request->get('parentMessageId');
        // Si un parentMessageId est fourni, recherche le message parent associé
        $parentMessage = null;
        if ($parentMessageId) {
            $parentMessage = $chatMessageRepository->find($parentMessageId);
        }

        // Créer un nouveau message
        $chatMessage = new ChatMessage();
        $chatMessage->setContent($messageContent);
        $chatMessage->setEventId($eventUid);

        // Associe l'utilisateur & message parent et persiste en BDD
        $chatMessage->setUser($authenticatedUser);
        $chatMessage->setParentMessage($parentMessage);
        $chatMessageRepository->save($chatMessage);

        $url = $this->generateUrl('app_event_show', ['eventUid' => $eventUid]);
        
        return $this->redirect($url);
    }
}