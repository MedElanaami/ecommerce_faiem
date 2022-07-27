<?php

namespace App\Controller\Backend;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/blog')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'admin_blog_index', methods: ['GET'])]
    public function index(BlogRepository $blogRepository): Response
    {
        return $this->render('backend/blog/index.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_blog_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BlogRepository $blogRepository): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogRepository->add($blog, true);

            return $this->redirectToRoute('admin_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'admin_blog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blog $blog, BlogRepository $blogRepository): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogRepository->add($blog, true);

            return $this->redirectToRoute('admin_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_blog_delete', methods: ['GET'])]
    public function delete(Request $request, Blog $blog, BlogRepository $blogRepository): Response
    {$blogRepository->remove($blog,true);

        return $this->redirectToRoute('admin_blog_index', [], Response::HTTP_SEE_OTHER);
    }

}
