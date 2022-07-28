<?php

namespace App\Controller\Frontend;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{slug}', name: 'app_categorie')]
    public function index(Categorie $categorie,  CategorieRepository $categorieRepository): Response
    {
        $categories= $categorieRepository->findAll();
        return $this->render('frontend/categorie.html.twig',
            ['categories'=>$categories,'categorie'=>$categorie]
        );
    }
}
