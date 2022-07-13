<?php

namespace App\Controller\Backend;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/slider')]
class SliderController extends AbstractController
{
    #[Route('/', name: 'app_slider_index', methods: ['GET'])]
    public function index(SliderRepository $sliderRepository): Response
    {
        return $this->render('backend/slider/index.html.twig', [
            'sliders' => $sliderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_slider_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SliderRepository $sliderRepository): Response
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sliderRepository->add($slider, true);

            return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/slider/new.html.twig', [
            'slider' => $slider,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_slider_show', methods: ['GET'])]
    public function show(Slider $slider): Response
    {
        return $this->render('slider/show.html.twig', [
            'slider' => $slider,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_slider_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Slider $slider, SliderRepository $sliderRepository): Response
    {
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sliderRepository->add($slider, true);

            return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/slider/edit.html.twig', [
            'slider' => $slider,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_slider_delete', methods: ['GET'])]
    public function delete(Request $request, Slider $slider, SliderRepository $sliderRepository): Response
    {$sliderRepository->remove($slider,true);

        return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
    }
}
