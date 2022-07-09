<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this-> render('frontend/index.html.twig');
    }
    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('contact.html.twig', [

            'page'=>'contact'

        ]);
    }
    #[Route('/service', name: 'service')]
    public function service(): Response
    {


        return $this->render('service.html.twig', [

            'page'=>"service"

        ]);
    }
    #[Route('/admin', name: 'admin_accueil')]
    public function adminAccueil(): Response
    {
        return $this->render('backend/accueil/index.html.twig', [


        ]);
    }
}
