<?php

namespace App\Repository;

use App\Document\ChatMessage;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class ChatMessageRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        // Appelle le constructeur parent de ServiceDocumentRepository
        // et lui passe le ManagerRegistry et la classe ChatMessage
        parent::__construct($registry, ChatMessage::class);
    }

    /**
     * Sauvegarde l'entité ChatMessage dans la base de données MongoDB.
     *
     * @param ChatMessage $entity L'entité ChatMessage à sauvegarder.
     */
    public function save(ChatMessage $event): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Persiste l'entité ChatMessage
        $objectManager->persist($event);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }

    /**
     * Supprime l'entité ChatMessage de la base de données MongoDB.
     *
     * @param ChatMessage $event L'entité ChatMessage à supprimer.
     */
    public function remove(ChatMessage $event): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Supprime l'entité ChatMessage de l'ObjectManager
        $objectManager->remove($event);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }
}
