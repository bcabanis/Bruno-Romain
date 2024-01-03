<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    // Redirection vers la page d'accueil
    #[Route('/', name: 'app_home')]
    public function index(SessionInterface $sessionInterface, UserRepository $userRepository): Response
    {

    // Récupère l'email de l'utilisateur connecté depuis la session
    $email = $sessionInterface->get('email');

    // Récupère l'utilisateur depuis la base de données en utilisant l'email
    $user = $userRepository->findOneBy(['email' => $email]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $user,
        ]);
    }

    // // Redirection vers la page d'accueil
    // #[Route('/a', name: 'app_home_page')]
    // public function page(SessionInterface $sessionInterface, UserRepository $userRepository): Response
    // {
        // // Récupère l'email de l'utilisateur connecté depuis la session
        // $email = $sessionInterface->get('email');

        // // Récupère l'utilisateur depuis la base de données en utilisant l'email
        // $user = $userRepository->findOneBy(['email' => $email]);

    //     return $this->render('base.html.twig', [
    //         'user' => $user,
    //     ]);
    // }


    // Redirection vers la page de présentation
    #[Route('/homepresentation', name: 'app_home_presentation')]
    public function presentation(): Response
    {
        return $this->render('home/presentation.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
