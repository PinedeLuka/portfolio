<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Query\Expr\Func;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortingController extends AbstractController
{
    #[Route('/sorting', name: 'app_sorting')]
    public function index(): Response
    {
        return $this->render('sorting/index.html.twig', [
            'controller_name' => 'SortingController',
        ]);
    }

    public function sortbar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSort'))
            ->add('sortingType', ChoiceType::class, [
                'choices' => [
                    'from the youngest to the oldest' => 1,
                    'from the oldest to the youngest' => 2,
                    'A -> Z' => 3,
                    'Z -> A' => 4,
                ],
                'label' => false,
            ])
            ->add('Search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-outline-light'
                ]
            ])
            ->getForm();
        return $this->render('project/sortBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/handleSort', name: "handleSort")]
    public function handleSearch(Request $request, ProjectRepository $repository)
    {
        $query = $request->request->all('form')['sortingType'];
        if ($query == 1) {
            $projects = $repository->findby([], ['date' => 'DESC']);
        } elseif ($query == 2) {
            $projects = $repository->findby([], ['date' => 'ASC']);
        } elseif ($query == 3) {
            $projects = $repository->findby([], ['name' => 'ASC']);
        } elseif ($query == 4) {
            $projects = $repository->findby([], ['name' => 'DESC']);
        }
        return $this->render('sorting/index.html.twig', [
            'projects' => $projects
        ]);
    }
}
