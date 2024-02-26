<?php

namespace App\Controller;

use App\Document\Events;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MigrationController extends AbstractController
{
    // Envoie des évenements en BDD
    #[Route('/migration_to_bdd', name: 'app_migration')]
    public function EventToBDD(EventRepository $eventRepository): Response
    {
        // Récupération du lien de l'api (json)
        $jsonData = './assets/json/event.json';

        // Decodage en string pour la lecture en php
        $eventsData = json_decode(file_get_contents($jsonData, true));

        // Boucle sur $eventData pour permettre l'insertion des données de l'événements dans la BDD
        foreach ($eventsData as $category => $events) {
            foreach ($events as $event) {
                foreach ($event as $e) {

                    // Variable qui va permettre la vérification de non doublons dans la BDD
                    $existingEvent = $eventRepository->findOneBy(['title' => $e->Titre]);

                    // Condition pour eviter des doublons d'événements dans la base de données 
                    if (!$existingEvent) {
                        $eventDoc = new Events();
                        $eventDoc->setCategory($category);
                        $eventDoc->setTitle($e->Titre);
                        $eventDoc->setDescription($e->Description);
                        $eventDoc->setEventDate($e->Date_de_l_evenement);
                        $eventDoc->setAddress($e->Adresse);
                        $eventDoc->setImageUrl($e->URL_d_image);
                        $eventDoc->seteventId($e->eventId);
                        $eventDoc->setDateFormat($e->date_format);
                        $eventDoc->setLong($e->Longitude);
                        $eventDoc->setLat($e->Latitude);
                        $eventDoc->setOrga($e->Organisateur);

                        // Enregistre dans la base de données
                        $eventRepository->save($eventDoc);
                    }
                }
            }
        }

        // Réponse si bon injection des données
        return new Response('Events inserted successfully!');
    }
}
