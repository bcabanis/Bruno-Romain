<?php

namespace App\Repository;

use App\Document\Users;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class UserRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        // Appelle le constructeur parent de ServiceDocumentRepository
        // et lui passe le ManagerRegistry et la classe Users
        parent::__construct($registry, Users::class);
        
    }
    /**
     * Sauvegarde l'entité Users dans la base de données MongoDB.
     *
     * @param Users $user L'entité Users à sauvegarder.
     */
    public function save(Users $user): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Persiste l'entité Users
        $objectManager->persist($user);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }

    /**
     * Supprime l'entité Users de la base de données MongoDB.
     *
     * @param Users $user L'entité Users à supprimer.
     */
    public function remove(Users $user): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Supprime l'entité Users de l'ObjectManager
        $objectManager->remove($user);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }


}
