<?php

namespace App\Controller;

use App\Entity\Project as EntityProject;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController{
    #[Route("/project/create", name:"create")]
    function create(Request $request, ManagerRegistry $doctrine) : Response{
        $project =  new EntityProject();
        $form = $this->createform(ProjectType::class, $project);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$doctrine->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
        }
        return $this->render('project/form.html.twig', [
            "form"=> $form->createView()   
        ]); 
    }

    #[Route("/project/edit/{id}", name:"edit")]
    function edit(Request $request, ManagerRegistry $doctrine, EntityProject $project) : Response {
        $form = $this->createform(ProjectType::class, $project);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $doctrine->getManager()->flush();
        }
        return $this->render("project/form.html.twig", [   
            "form"=>$form->createView()
        ]);
    }

    #[Route("/project/delete/{id}", name:"delete")]
    public function delete(ManagerRegistry $doctrine, EntityProject $project) : Response {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($project);
        $entityManager->flush();
        return $this->redirectToRoute("homepage");
    }
}