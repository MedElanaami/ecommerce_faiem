<?php

namespace App\Controller\Frontend;

use App\Entity\Produit;
use App\Repository\CouponRepository;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
class ProduitController extends AbstractController
{
    #[Route('/produit/{slug}', name: 'app_produit')]
    public function index(Produit $produit, Request $request): Response
    {
        return $this->render('frontend/produit.html.twig', [
            'produit' => $produit,
        ]);
    }
    #[Route('/wishlist', name: 'app_wishlist')]
    public function wishList(Request $request): Response
    {

        return $this->render('frontend/favoris.html.twig', [
            'produits'=>$request->getSession()->get('wishList')

        ]);
    }

    #[Route('/ajouterProduit/{id}', name: 'app_ajouter_produit', options: ['expose' => true])]
    public function ajouterProduit(Produit $produit, Request $request, CouponRepository $couponRepository): Response
    {

        $qte = $request->get('qte');
        if ($qte) {
            $session = $request->getSession();
            $produits = $session->get('produits');
            if ($produits == null) {
                $produits = [];
            };
            $produitExist = false;
            foreach ($produits as $key => $produitCmd) {
                if ($produitCmd['id'] == $produit->getId()) {
                    $produits[$key]['qte'] = $produitCmd['qte'] + $qte;
                    $produitExist = true;
                }
            }
            if (!$produitExist) {
                $produits[] = ['id' => $produit->getId(),
                    'nom' => $produit->getNom(),
                    'slug' => $produit->getSlug(),
                    'prix' => $produit->getPrixReduction(),
                    'imageName' => $produit->getImages()[0]->getImageName(),
                    'qte' => $qte];
            }
            $session->set('produits', $produits);
            $this->setPrixTotal($request, $couponRepository);
            return new JsonResponse(['content' => $this->renderView('frontend/layouts/panier.html.twig', ['produits_cmd' => $session->get('produits')]), 'nbrProduits' => count($produits), 'message' => 'L\'article a été ajouté à votre panier']);
        }
        return $this->render('frontend/produit.html.twig', [
            'produit' => $produit,
        ]);


    }


    #[Route('/supprimerProduit/{key}', name: 'app_supprimer_produit')]
    public function supProduit($key, Request $request, CouponRepository $couponRepository)
    {
        $session = $request->getSession();
        $produits = $session->get('produits');
        unset($produits[$key]);
        $session->set('produits', $produits);
        $this->setPrixTotal($request, $couponRepository);
        return $this->redirect($request->headers->get('referer'));
    }

    public function setPrixTotal(Request $request, CouponRepository $couponRepository)
    {
        $prixTotal = 0;
        $session = $request->getSession();
        $produits = $session->get('produits');
        foreach ($produits as $produit)
            $prixTotal += $produit['qte'] * $produit['prix'];
        if ($session->get("codeCoupon")) {
            $coupon = $couponRepository->find($session->get('codeCoupon'));
            if ($coupon) {
                if ($coupon->getTypeReduction()->getNom() == 'Prix')
                    $prixTotal = $prixTotal - $coupon->getValeur();
                else
                    $prixTotal = $prixTotal * (1 - $coupon->getValeur() / 100);

            }
        }
        $session->set('prixTotal', $prixTotal);
    }

    #[Route('/modifierProduit/', name: 'app_modifier_produit')]
    public function modProduit(Request $request, CouponRepository $couponRepository)
    {
        $session = $request->getSession();
        $produits = $session->get('produits');
        if ($request->isXmlHttpRequest()) {
            $produitId = $request->get('produit');
            foreach ($produits as $key => $produit) {
                if ($produit['id'] == $produitId) {
                    $produits[$key]['qte'] = $request->get('qte');

                }
            }
            $session->set('produits', $produits);
            $this->setPrixTotal($request, $couponRepository);
            return new JsonResponse($session->get('prixTotal'));
        }


    }

    #[Route('/ajouterProduitWishList/{id}', name: 'app_ajouter_produit_wishlist', options: ['expose' => true])]
    public function ajouterProduitWishList(Produit $produit, Request $request): Response
    {

         if($request->isXmlHttpRequest()) {
             $session = $request->getSession();
             $wishList = $session->get('wishList');
             if ($wishList == null) {
                 $wishList = [];
             };
             $produitExist = false;
             foreach ($wishList as $key => $produitFavoris) {
                 if ($produitFavoris['id'] == $produit->getId()) {
                     $produitExist = true;
                 }
             }
             if (!$produitExist) {
                 $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
                 $normalizer = new ObjectNormalizer($classMetadataFactory);
                 $serializer = new Serializer([$normalizer]);
                 $data = $serializer->normalize($produit);
                 $wishList[] = $data;
             }
             $session->set('wishList', $wishList);

             return new JsonResponse(['message' => 'L\'article a été ajouté à votre favoris']);
         }
         return $this->redirectToRoute("app_accueil");

    }


}
