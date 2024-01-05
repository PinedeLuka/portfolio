<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route("/project/create", name: "create")]
    function create(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $project =  new Project();
        $form = $this->createform(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $project->setBrochureFilename($brochureFileName);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
        }
        return $this->render('project/form.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route("/project/edit/{id}", name: "edit")]
    function edit(Request $request, ManagerRegistry $doctrine, Project $project, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createform(ProjectType::class, $project);
       

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $project->setBrochureFilename($brochureFileName);
            }
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('work');
        }
        return $this->render("project/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route("/project/delete/{id}", name: "delete")]
    public function delete(ManagerRegistry $doctrine, Project $project): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($project);
        $entityManager->flush();
        return $this->redirectToRoute("work");
    }

    #[Route("/project/read", name: "work")]
    public function read(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Project::class);
        $projects = $repository->findby([], ['date' => 'ASC']);
        return $this->render("project/Work.html.twig", [
            "projects" => $projects,
        ]);
    }
}