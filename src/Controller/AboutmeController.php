<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutmeController extends AbstractController
{
    #[Route("/skillcreate", name: "skillcreate")]
    function create(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $skill =  new Skill();
        $form = $this->createform(SkillType::class, $skill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $skill->setBrochureFilename($brochureFileName);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($skill);
            $entityManager->flush();
            
        }
        return $this->render('project/skillForm.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route("/skilledit/{id}", name: "skilledit")]
    function edit(Request $request, ManagerRegistry $doctrine, Skill $skill, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createform(SkillType::class, $skill);
       

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $skill->setBrochureFilename($brochureFileName);
            }
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('aboutme');
        }
        return $this->render("project/skillForm.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route("/skilldelete/{id}", name: "skilldelete")]
    public function delete(ManagerRegistry $doctrine, Skill $skill): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($skill);
        $entityManager->flush();
        return $this->redirectToRoute("aboutme");
    }

    #[Route("/aboutme", name: "aboutme")]
    public function aboutme(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Skill::class);
        $skills = $repository->findAll();
        return $this->render("project/aboutme.html.twig", [
            "skills" => $skills
        ]);
    }
}