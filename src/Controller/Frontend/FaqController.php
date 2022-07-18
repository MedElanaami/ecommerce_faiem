<?php

namespace App\Controller\Frontend;

use App\Repository\FaqRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')]
    public function index(FaqRepository $faqRepository): Response
    {
        $faqs= $faqRepository->findAll();



        return $this->render('frontend/faq.html.twig',
            ['faqs'=>$faqs]
        );
    }
}
