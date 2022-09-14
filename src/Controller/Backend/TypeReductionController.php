<?php

namespace App\Controller\Backend;

use App\Entity\TypeReduction;
use App\Form\TypeReductionType;
use App\Repository\TypeReductionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/typeReduction')]
class TypeReductionController extends AbstractController
{
    #[Route('/', name: 'app_typeReduction_index', methods: ['GET'])]
    public function index(TypeReductionRepository $typeReductionRepository): Response
    {
        return $this->render('backend/typeReduction/index.html.twig', [
            'typesReduction' => $typeReductionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_typeReduction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeReductionRepository $typeReductionRepository): Response
    {
        $typeReduction = new TypeReduction();
        $form = $this->createForm(TypeReductionType::class, $typeReduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeReductionRepository->add($typeReduction, true);

            return $this->redirectToRoute('app_typeReduction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/typeReduction/new.html.twig', [
            'typeReduction' => $typeReduction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typeReduction_show', methods: ['GET'])]
    public function show(TypeReduction $typeReduction): Response
    {
        return $this->render('typeReduction/show.html.twig', [
            'typeReduction' => $typeReduction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_typeReduction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeReduction $typeReduction, TypeReductionRepository $typeReductionRepository): Response
    {
        $form = $this->createForm(TypeReductionType::class, $typeReduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeReductionRepository->add($typeReduction, true);

            return $this->redirectToRoute('app_typeReduction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/typeReduction/edit.html.twig', [
            'typeReduction' => $typeReduction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_typeReduction_delete', methods: ['GET'])]
    public function delete(Request $request, TypeReduction $typeReduction, TypeReductionRepository $typeReductionRepository): Response
    {$typeReductionRepository->remove($typeReduction,true);

        return $this->redirectToRoute('app_typeReduction_index', [], Response::HTTP_SEE_OTHER);
    }
}
