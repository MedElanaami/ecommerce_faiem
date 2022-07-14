<?php

namespace App\Controller\Backend;

use App\Entity\Image;
use App\Entity\Produit;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/image')]
class ImageController extends AbstractController
{
    #[Route('/produit/{id}', name: 'app_image_index', methods: ['GET','POST'])]
    public function index(Request $request,ImageRepository $imageRepository,Produit $produit): Response
    {
        $image = new Image();
        $image->setProduit($produit);
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageRepository->add($image, true);

            return $this->redirectToRoute('app_image_index', ['id'=>$produit->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/image/index.html.twig', [
            'produit'=>$produit,
            'form'=>$form->createView()
        ]);
    }

    #[Route('/new', name: 'app_image_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ImageRepository $imageRepository): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageRepository->add($image, true);

            return $this->redirectToRoute('app_image_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/image/new.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_image_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Image $image, ImageRepository $imageRepository): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        $produit=$image->getProduit();
        if ($form->isSubmitted() && $form->isValid()) {
            $imageRepository->add($image, true);

            return $this->redirectToRoute('app_image_index', ['id'=>$produit->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/image/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_image_delete', methods: ['GET'])]
    public function delete(Request $request, Image $image, ImageRepository $imageRepository): Response
    {   $produit=$image->getProduit();
        $imageRepository->remove($image,true);

        return $this->redirectToRoute('app_image_index', ['id'=>$produit->getId()], Response::HTTP_SEE_OTHER);

    }
}
