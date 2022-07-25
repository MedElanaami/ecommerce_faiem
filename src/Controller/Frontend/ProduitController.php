<?php

namespace App\Controller\Frontend;

use App\Entity\Produit;
use App\Repository\CouponRepository;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit/{slug}', name: 'app_produit')]
    public function index(Produit $produit, Request $request, CouponRepository $couponRepository): Response
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
            if ($produitExist == false) {
                array_push($produits,
                    ['id' => $produit->getId(),
                        'nom' => $produit->getNom(),
                        'slug' => $produit->getSlug(),
                        'prix' => $produit->prixReduction(),
                        'imageName' => $produit->getImages()[0]->getImageName(),
                        'qte' => $qte]
                );
            }
            $session->set('produits', $produits);
            $this->setPrixTotal($request, $couponRepository);
            $this->addFlash('success', "L'article a été ajouté à votre panier");
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

}
