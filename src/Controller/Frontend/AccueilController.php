<?php

namespace App\Controller\Frontend;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use App\Repository\ProduitRepository;
use App\Repository\SliderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/',name: 'app_accueil',options:['expose' => true])]
    public function index(Request $request,ProduitRepository $produitRepository, SliderRepository $sliderRepository,PaginatorInterface $paginator): Response
    {
        $sliders=$sliderRepository->findAll();

        if ($request->isXmlHttpRequest()) {
            $page = $request->get('page');


            $produits = $paginator->paginate(
                $produitRepository->findAll(), // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', $page), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                8// Nombre de résultats par page
            );

            return new JsonResponse(['content' => $this->renderView('frontend/layouts/produits.html.twig', ['produits' => $produits])]);
        }

        $produits = $paginator->paginate(
            $produitRepository->findAll(), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            8 // Nombre de résultats par page
        );
        return $this->render('frontend/index.html.twig',['produits'=>$produits,'sliders'=>$sliders]);
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


    #[Route('/Confidentialité', name: 'p_conf')]
    public function pConf(): Response
    {

        return $this->render('frontend/conf.html.twig');
    }
    #[Route('/Retour', name: 'p_retour')]
    public function pRetour(): Response
    {

        return $this->render('frontend/retour.html.twig');
    }
}
