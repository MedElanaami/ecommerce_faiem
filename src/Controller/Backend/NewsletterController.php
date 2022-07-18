<?php

namespace App\Controller\Backend;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/newsletter')]
class NewsletterController extends AbstractController
{
    #[Route('/', name: 'admin_newsletter_index', methods: ['GET'])]
    public function index(NewsletterRepository $newsletterRepository): Response
    {
        return $this->render('backend/newsletter/index.html.twig', [
            'newsletters' => $newsletterRepository->findAll(),

        ]);
    }

    #[Route('/new', name: 'admin_newsletter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NewsletterRepository $newsletterRepository): Response
    {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsletterRepository->add($newsletter, true);

            return $this->redirectToRoute('admin_newsletter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/newsletter/new.html.twig', [
            'newsletter' => $newsletter,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'admin_newsletter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Newsletter $newsletter, NewsletterRepository $newsletterRepository): Response
    {
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsletterRepository->add($newsletter, true);

            return $this->redirectToRoute('admin_newsletter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/newsletter/edit.html.twig', [
            'newsletter' => $newsletter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_newsletter_delete', methods: ['GET'])]
    public function delete(Request $request, Newsletter $newsletter, NewsletterRepository $newsletterRepository): Response
    {$newsletterRepository->remove($newsletter,true);

        return $this->redirectToRoute('admin_newsletter_index', [], Response::HTTP_SEE_OTHER);
    }
}
