<?php

namespace App\Controller\Backend;

use App\Entity\Parametre;
use App\Form\ParametreType;
use App\Repository\ParametreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/parametre')]
class ParametreController extends AbstractController
{
    #[Route('/', name: 'admin_parametre_index', methods: ['GET'])]
    public function index(ParametreRepository $parametreRepository): Response
    {
        return $this->render('backend/parametre/index.html.twig', [
            'parametre' => $parametreRepository->findOneBy([]),
        ]);

    }

    #[Route('/new', name: 'admin_parametre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ParametreRepository $parametreRepository): Response
    {
        $parametre = new Parametre();
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametreRepository->add($parametre, true);

            return $this->redirectToRoute('admin_parametre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/parametre/new.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'admin_parametre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parametre $parametre, ParametreRepository $parametreRepository): Response
    {
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametreRepository->add($parametre, true);

            return $this->redirectToRoute('admin_parametre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/parametre/edit.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_parametre_delete', methods: ['GET'])]
    public function delete(Request $request, Parametre $parametre, ParametreRepository $parametreRepository): Response
    {$parametreRepository->remove($parametre,true);

        return $this->redirectToRoute('admin_parametre_index', [], Response::HTTP_SEE_OTHER);
    }
}
