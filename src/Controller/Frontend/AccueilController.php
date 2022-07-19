<?php

namespace App\Controller\Frontend;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig');
    }



    #[Route('/admin', name: 'admin_accueil')]
    public function adminAccueil(): Response
    {
        return $this->render('backend/accueil/index.html.twig', [


        ]);
    }

    #[Route('/newsletter', name: 'newsletter')]
    public function newsletter(Request $request, NewsletterRepository $newsletterRepository): Response
    {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $newsletterRepository->add($newsletter, true);
            $this->addFlash('success', 'Merci votre inscription a bien été prise en compte!!');
           return $this->redirect($request->headers->get('referer'));

        }
        return $this->redirectToRoute('app_accueil');
    }

    #[Route('/contact-test', name: 'contact-test')]
    public function contactTest(): Response
    {
        $data=['nom'=>"med",'email'=>'med@gmail.com','tel'=>'024653','message'=>'lorem hcjgchgdlkjgghghj gfrhjb jhg fdg  '];
        return $this->render('frontend/emails/contact.html.twig', [ 'data'=>$data


        ]);
    }
}
