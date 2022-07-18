<?php

namespace App\Controller\Backend;

use App\Entity\Faq;
use App\Form\FaqType;
use App\Repository\FaqRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/faq')]
class FaqController extends AbstractController
{
    #[Route('/', name: 'admin_faq_index', methods: ['GET'])]
    public function index(FaqRepository $faqRepository): Response
    {
        return $this->render('backend/faq/index.html.twig', [
            'faqs' => $faqRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_faq_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FaqRepository $faqRepository): Response
    {
        $faq = new Faq();
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faqRepository->add($faq, true);

            return $this->redirectToRoute('admin_faq_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/faq/new.html.twig', [
            'faq' => $faq,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_faq_show', methods: ['GET'])]
    public function show(Faq $faq): Response
    {
        return $this->render('faq/show.html.twig', [
            'faq' => $faq,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_faq_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Faq $faq, FaqRepository $faqRepository): Response
    {
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faqRepository->add($faq, true);

            return $this->redirectToRoute('admin_faq_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/faq/edit.html.twig', [
            'faq' => $faq,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_faq_delete', methods: ['GET'])]
    public function delete(Request $request, Faq $faq, FaqRepository $faqRepository): Response
    {$faqRepository->remove($faq,true);

        return $this->redirectToRoute('admin_faq_index', [], Response::HTTP_SEE_OTHER);
    }
}
