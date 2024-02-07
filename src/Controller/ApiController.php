<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// le but de cette classe est de faire apparaitre les résultats de l'API

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function getDatas(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
