<?php

namespace App\Repository;

use App\Document\Calendar;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class CalendarRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        // Appelle le constructeur parent de ServiceDocumentRepository
        // et lui passe le ManagerRegistry et la classe Calendar
        parent::__construct($registry, Calendar::class);
        
    }
    /**
     * Sauvegarde l'entité Calendar dans la base de données MongoDB.
     *
     * @param Calendar $calendar L'entité Users à sauvegarder.
     */
    public function save(Calendar $calendar): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Persiste l'entité Users
        $objectManager->persist($calendar);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }

    /**
     * Supprime l'entité Users de la base de données MongoDB.
     *
     * @param Calendar $calendar L'entité Users à supprimer.
     */
    public function remove(Calendar $calendar): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Supprime l'entité Users de l'ObjectManager
        $objectManager->remove($calendar);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }


}
