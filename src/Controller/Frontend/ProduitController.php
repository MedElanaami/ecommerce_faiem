<?php

namespace App\Controller\Frontend;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit/{slug}', name: 'app_produit')]
    public function index(Produit $produit): Response
    {
        return $this->render('frontend/produit.html.twig', [
            'produit' => $produit,

        ]);
    }
}
