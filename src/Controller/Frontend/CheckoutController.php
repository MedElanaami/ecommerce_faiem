<?php

namespace App\Controller\Frontend;


use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Coupon;
use App\Entity\LigneCommande;
use App\Entity\Produit;
use App\Form\RegistrationClientType;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Security $security): Response
    {
        $session = $request->getSession();
        $session->set('route', "app_checkout");
        if ($session->get("produits") && count($session->get("produits")) > 0) {


            if ($this->getUser() && $security->isGranted('ROLE_CLIENT')) {
                $user = $this->getUser();
            } else
                $user = new Client();
            $form = $this->createForm(RegistrationClientType::class, $user);
            if ($this->getUser() && $security->isGranted('ROLE_CLIENT')) {
                $form->remove("plainPassword");
                $form->remove("username");
            }
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                if (!$this->getUser()) {
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                        )
                    );
                }
                $entityManager->persist($user);
                $entityManager->flush();
                $commande = new Commande();
                $commande->setClient($user);
                $commande->setPrixTotal($session->get('prixTotal'));
                if ($session->get('codeCoupon')) {
                    $coupon = $entityManager->getRepository(Coupon::class)->find($session->get('codeCoupon'));
                    if ($coupon) {
                        $commande->setCoupon($coupon);
                        $commande->setCouponApplique(true);
                    }
                }
                $entityManager->persist($commande);
                $entityManager->flush();
                $produits = $session->get('produits');
                foreach ($produits as $produitSession) {
                    $ligneCommande = new LigneCommande();
                    $produit = $entityManager->getRepository(Produit::class)->find($produitSession['id']);
                    if ($produit) {
                        $ligneCommande->setProduit($produit);
                        $ligneCommande->setCommande($commande);
                        $ligneCommande->setPrixVente($produitSession['prix']);
                        $ligneCommande->setQte($produitSession['qte']);
                        $entityManager->persist($ligneCommande);
                        $entityManager->flush();
                    }
                }
                $session->remove('produits');
                $session->remove('prixTotal');
                $session->remove('codeCoupon');
                $this->addFlash('success', 'Votre commande a été bien enregistrée, nous vous contacterons le plus tôt possible.');
                return $this->redirectToRoute("app_accueil");
            }
            return $this->render('frontend/checkout.html.twig', ['form' => $form->createView()]);
        } else {
            return $this->redirectToRoute("app_accueil");

        }
    }
}
