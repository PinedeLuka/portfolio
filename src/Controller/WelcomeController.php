<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/welcome', name: 'app_welcome')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTIFICATED_FULLY');

        $user=$this->getUser();
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }
}
