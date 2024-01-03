<?php

namespace App\Repository;

use App\Document\Category;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class CategoryRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        // Appelle le constructeur parent de ServiceDocumentRepository
        // et lui passe le ManagerRegistry et la classe Category
        parent::__construct($registry, Category::class);
    }

    /**
     * Récupère toutes les catégories depuis la base de données MongoDB.
     *
     * @return Category[] La liste des catégories.
     */
    public function findAllCategories(): array
    {
        return $this->findAll();
    }

    /**
     * Sauvegarde l'entité Category dans la base de données MongoDB.
     *
     * @param Category $category L'entité Category à sauvegarder.
     */
    public function save(Category $category): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Persiste l'entité Category
        $objectManager->persist($category);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }

    /**
     * Supprime l'entité Category de la base de données MongoDB.
     *
     * @param Category $category L'entité Category à supprimer.
     */
    public function remove(Category $category): void
    {
        // Obtient l'ObjectManager spécifique à MongoDB (ODM) de Doctrine
        $objectManager = $this->getDocumentManager();

        // Supprime l'entité Category de l'ObjectManager
        $objectManager->remove($category);

        // Enregistre les modifications dans la base de données
        $objectManager->flush();
    }
}
