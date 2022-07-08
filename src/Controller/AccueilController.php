<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
         if($this->getUser())
         {
             return  $this->redirectToRoute('admin_accueil');
         }
         else
             return $this->redirectToRoute('app_login');
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
        return $this->render('accueil/index.html.twig', [


        ]);
    }
}
