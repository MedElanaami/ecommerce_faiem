<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\EditPasswordType;
use App\Form\ProfileAdminType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/admin/profile', name: 'admin_profile')]
    public function index(): Response
    {
        return $this->render('backend/profile/index.html.twig'
        );
    }

    #[Route('/admin/profile/editer', name: 'admin_editer_profile')]
    public function edite(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileAdminType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_profile');
        }

        return $this->render('backend/profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/editPassword', name: 'admin_editer_password')]
    public function editPassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($userPasswordHasher->isPasswordValid($user, $form->get('password')->getData())) {

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $entityManager->persist($user);
                $this->addFlash("success","Le mot de passe a été changé avec succès");
                $entityManager->flush(); return $this->redirectToRoute('admin_profile');

            }
            else{
                $this->addFlash("error","Le mot de passe que vous avez saisi est incorrecte ");
            }
        }

        return $this->render('backend/profile/edit_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
