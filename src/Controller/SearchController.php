<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends AbstractController
{

    public function searchBar(){
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Search a project'
                ]
            ])
            ->add('Search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-outline-light'
                ]
            ])
            ->getForm();
        return $this->render('search//searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/handleSearch', name:"handleSearch")]
    public function handleSearch(Request $request, ProjectRepository $repo){
        $query = $request->request->all('form')['query'];
        if($query){
            $projects = $repo->findProjectByName($query);
        }
        return $this->render('search/index.html.twig', [
            'projects' => $projects
        ]);
    }
}
