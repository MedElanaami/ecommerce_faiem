<?php

namespace App\Controller\Frontend;


use App\Form\RegistrationClientType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    #[Route('/client/profile', name: 'app_profile')]
    public function index(Request $request,CommandeRepository $commandeRepository, EntityManagerInterface $entityManager,Security $security): Response
    {
        $user= $this->getUser();
        $commandes=$commandeRepository->findBy(['client'=>$user]);
        $form = $this->createForm(RegistrationClientType::class, $user);
        if ($this->getUser() && $security->isGranted('ROLE_CLIENT')) {
            $form->remove("plainPassword");

        }
        $user = $this->getUser();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
        }
         return $this->renderForm('frontend/profile.html.twig',['form'=>$form,'commandes'=>$commandes]

        );
    }
}
