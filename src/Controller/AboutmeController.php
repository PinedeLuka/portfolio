<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutmeController extends AbstractController{
    #[Route(path:"/aboutme", name:"aboutme")]
    public function aboutme(): Response
    {
        return $this->render('project/aboutme.html.twig', [
            'controller_name'=>'AboutmeController'            
        ]);
    }
}