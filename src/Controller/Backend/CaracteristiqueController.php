<?php

namespace App\Controller\Backend;

use App\Entity\Caracteristique;
use App\Form\CaracteristiqueType;
use App\Repository\CaracteristiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/caracteristique')]
class CaracteristiqueController extends AbstractController
{
    #[Route('/', name: 'app_caracteristique_index', methods: ['GET'])]
    public function index(CaracteristiqueRepository $caracteristiqueRepository): Response
    {
        return $this->render('backend/caracteristique/index.html.twig', [
            'caracteristiques' => $caracteristiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_caracteristique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CaracteristiqueRepository $caracteristiqueRepository): Response
    {
        $caracteristique = new Caracteristique();
        $form = $this->createForm(CaracteristiqueType::class, $caracteristique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $caracteristiqueRepository->add($caracteristique, true);

            return $this->redirectToRoute('app_caracteristique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/caracteristique/new.html.twig', [
            'caracteristique' => $caracteristique,
            'form' => $form,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_caracteristique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Caracteristique $caracteristique, CaracteristiqueRepository $caracteristiqueRepository): Response
    {
        $form = $this->createForm(CaracteristiqueType::class, $caracteristique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $caracteristiqueRepository->add($caracteristique, true);

            return $this->redirectToRoute('app_caracteristique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/caracteristique/edit.html.twig', [
            'caracteristique' => $caracteristique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_caracteristique_delete', methods: ['GET'])]
    public function delete(Request $request, Caracteristique $caracteristique, CaracteristiqueRepository $caracteristiqueRepository): Response
    {$caracteristiqueRepository->remove($caracteristique,true);

        return $this->redirectToRoute('app_caracteristique_index', [], Response::HTTP_SEE_OTHER);
    }
}
