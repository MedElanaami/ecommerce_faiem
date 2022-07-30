<?php

namespace App\Controller\Backend;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tag')]
class TagController extends AbstractController
{
    #[Route('/', name: 'admin_tag_index', methods: ['GET'])]
    public function index(TagRepository $tagRepository): Response
    {
        return $this->render('backend/tag/index.html.twig', [
            'tags' => $tagRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_tag_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TagRepository $tagRepository): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRepository->add($tag, true);

            return $this->redirectToRoute('admin_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'admin_tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag, TagRepository $tagRepository): Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRepository->add($tag, true);

            return $this->redirectToRoute('admin_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_tag_delete', methods: ['GET'])]
    public function delete(Request $request, Tag $tag, TagRepository $tagRepository): Response
    {$tagRepository->remove($tag,true);

        return $this->redirectToRoute('admin_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
