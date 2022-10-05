<?php

namespace App\Controller\Frontend;

use App\Entity\Client;
use App\Form\RegistrationClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $client = new Client();
        $form = $this->createForm(RegistrationClientType::class,$client);
        $form->remove('codePostal');
        $form->remove('ville');
        $form->remove('adresse');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client->setPassword(
                $userPasswordHasher->hashPassword(
                    $client,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($client);
            $entityManager->flush();
            $this->addFlash('success','Votre compte a été créé avec succès, merci de se connecter');
            return $this->redirectToRoute('app_accueil');
        }
            return $this->renderForm('frontend/inscription.html.twig',['form'=>$form]);
        }

}

