<?php

namespace App\Controller\Backend;

use App\Entity\Attribut;
use App\Form\AttributType;
use App\Repository\AttributRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/attribut')]
class AttributController extends AbstractController
{
    #[Route('/', name: 'app_attribut_index', methods: ['GET'])]
    public function index(AttributRepository $attributRepository): Response
    {
        return $this->render('backend/attribut/index.html.twig', [
            'attributs' => $attributRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_attribut_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AttributRepository $attributRepository): Response
    {
        $attribut = new Attribut();
        $form = $this->createForm(AttributType::class, $attribut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributRepository->add($attribut, true);

            return $this->redirectToRoute('app_attribut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/attribut/new.html.twig', [
            'attribut' => $attribut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attribut_show', methods: ['GET'])]
    public function show(Attribut $attribut): Response
    {
        return $this->render('attribut/show.html.twig', [
            'attribut' => $attribut,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_attribut_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Attribut $attribut, AttributRepository $attributRepository): Response
    {
        $form = $this->createForm(AttributType::class, $attribut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributRepository->add($attribut, true);

            return $this->redirectToRoute('app_attribut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/attribut/edit.html.twig', [
            'attribut' => $attribut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_attribut_delete', methods: ['GET'])]
    public function delete(Request $request, Attribut $attribut, AttributRepository $attributRepository): Response
    {$attributRepository->remove($attribut,true);

        return $this->redirectToRoute('app_attribut_index', [], Response::HTTP_SEE_OTHER);
    }
}
