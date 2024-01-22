<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\CalendarRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function index(CalendarRepository $calendarRepository, EventRepository $eventRepository): Response
    {
        // Recherche des événements dans la base de données
        $events = $eventRepository->findAll();
    
        // // Initialisez le tableau pour stocker tous les titres
        // $titles = [];
        
        // Initialisez le tableau pour stocker tous les événements
        $calendarEvents = [];
    
        // Boucle sur tous les événements pour récupérer les données et les afficher
        foreach ($events as $event) {
            $calendarEvent = [
                'title' => $event->getTitle(),
                'start' => $event->getDateFormat()->format('Y-m-d'),
                'end' => $event->getDateFormat()->format('Y-m-d'),
            ];
            // $titles[] = $title; 
            // $dateFormats[] = $dateFormat; 
            $calendarEvents[] = $calendarEvent;
        }
    
        dump($calendarEvents);
        // dump($events);
        // dump($titles);
        // dump($dateFormats);
    
        return $this->render('calendar/index.html.twig', [
            'controller_name' => 'CalendarController',
            'calendarEvents' => $calendarEvents,
        ]);
    }
}
