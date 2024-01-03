<?php

namespace App\Repository;

use App\Document\Events;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class EventRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        // Appelle le constructeur parent de ServiceDocumentRepository
        // et lui passe le ManagerRegistry et la classe Events
        parent::__construct($registry, Events::class);
    }

    /**
     * Sauvegarde l'entité Events dans la base de données MongoDB.
     *
     * @param Events $entity L'entité Events à sauvegarder.
     */
    public function save(Events $event): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Persiste l'entité Events
        $objectManager->persist($event);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }

    /**
     * Supprime l'entité Events de la base de données MongoDB.
     *
     * @param Events $event L'entité Events à supprimer.
     */
    public function remove(Events $event): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Supprime l'entité Events de l'ObjectManager
        $objectManager->remove($event);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }
}
