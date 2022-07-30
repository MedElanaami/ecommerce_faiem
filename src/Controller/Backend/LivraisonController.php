<?php

namespace App\Controller\Backend;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/livraison')]
class LivraisonController extends AbstractController
{
    #[Route('/', name: 'admin_livraison_index', methods: ['GET'])]
    public function index(LivraisonRepository $livraisonRepository): Response
    {
        return $this->render('backend/livraison/index.html.twig', [
            'livraisons' => $livraisonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_livraison_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LivraisonRepository $livraisonRepository): Response
    {
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livraisonRepository->add($livraison, true);

            return $this->redirectToRoute('admin_livraison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/livraison/new.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'admin_livraison_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livraison $livraison, LivraisonRepository $livraisonRepository): Response
    {
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livraisonRepository->add($livraison, true);

            return $this->redirectToRoute('admin_livraison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/livraison/edit.html.twig', [
            'livraison' => $livraison,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_livraison_delete', methods: ['GET'])]
    public function delete(Request $request, Livraison $livraison, LivraisonRepository $livraisonRepository): Response
    {$livraisonRepository->remove($livraison,true);

        return $this->redirectToRoute('admin_livraison_index', [], Response::HTTP_SEE_OTHER);
    }
}
