<?php

namespace App\Controller\Frontend;


use App\Entity\Commande;
use App\Form\EditPasswordType;
use App\Form\RegistrationClientType;
use App\Repository\CommandeRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    #[Route('/client/profile', name: 'app_profile')]
    public function index(Request $request,CommandeRepository $commandeRepository,UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,Security $security): Response
    {
        $user= $this->getUser();
        $commandes=$commandeRepository->findBy(['client'=>$user]);
        $form = $this->createForm(RegistrationClientType::class, $user);
        if ($this->getUser() && $security->isGranted('ROLE_CLIENT')) {
            $form->remove("plainPassword");
        }
        $form->handleRequest($request);
        $form1 = $this->createform(EditPasswordType::class, $user);
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            if ($userPasswordHasher->isPasswordValid($user, $form1->get('password')->getData())) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form1->get('plainPassword')->getData()
                    )
                );
                $entityManager->persist($user);
                $this->addFlash("success","Le mot de passe a été changé avec succès");
                $entityManager->flush(); return $this->redirectToRoute('app_profile');

            }
            else{
                $this->addFlash("error","Le mot de passe que vous avez saisi est incorrecte ");
            }
        }
        else{
            $this->addFlash("error","Erreur lors du modification du mot de passe ");
        }
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
        }
         return $this->renderForm('frontend/profile.html.twig',['form'=>$form,'form1'=>$form1,'commandes'=>$commandes]

        );
    }
    #[Route('/client/annuler-commande/{id}', name: 'app_annuler_commande')]
    public function annulerCMD(Request $request,Commande $commande,CommandeRepository $commandeRepository,StatusRepository $statusRepository): Response
    {
        $status=$statusRepository->find(3);
        if( $status)
        {
            $commande->setStatus($status);
            $commandeRepository->add($commande,true);
        }

        return $this->redirectToRoute('app_profile');

    }
}
