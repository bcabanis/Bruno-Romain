<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Servira à gérer les notifications

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(): Response
    {


        echo sys_get_temp_dir();

        return $this->render('notification/index.html.twig', [
            'controller_name' => 'NotificationController',
        ]);
    }
}
