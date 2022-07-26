<?php

namespace App\Controller\Backend;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'admin_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('backend/commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }
    #[Route('/details/{id}', name: 'admin_commande_details',  options: ['expose' => true],methods: ['GET'] )]
    public function details(Commande $commande ,CommandeRepository $commandeRepository): Response
    {
        $commande->setVu(true);
        $commandeRepository->add($commande ,true);

        return $this->render('backend/commande/details.html.twig', [
            'commande' => $commande
        ]);
    }

    #[Route('/new', name: 'admin_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeRepository $commandeRepository): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->add($commande, true);

            return $this->redirectToRoute('admin_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

  
    #[Route('/{id}/edit', name: 'admin_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->add($commande, true);

            return $this->redirectToRoute('admin_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_commande_delete', methods: ['GET'])]
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {$commandeRepository->remove($commande,true);

        return $this->redirectToRoute('admin_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
