<?php

namespace App\Controller\Backend;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('backend/produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->add($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->add($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backend/produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_produit_delete', methods: ['GET'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {$produitRepository->remove($produit,true);

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/categories/{id}', name: 'app_produit_categories', methods: ['GET'])]
    public function categories( Produit $produit , ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $categories= $categorieRepository->findby(['parent'=>NULL]);

        return $this->render('backend/produit/categories.html.twig', [
            'categories'=>$categories,
            'produit' => $produit
        ]);
    }
    #[Route('/categories/ajouter/{produit}/{categorie}', name: 'app_ajouter_produit_categorie', methods: ['GET'])]
    public function ajouterCategorie( Produit $produit ,Categorie $categorie, ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $produit->addCategory($categorie);
        while( $categorie->getParent()) {
            $produit->addCategory($categorie->getParent());
            $categorie=$categorie->getParent();
        }
        $produitRepository->add($produit,true);
       return $this->redirectToRoute('app_produit_categories',['id'=>$produit->getId()]);
    }
    #[Route('/categories/supprimer/{produit}/{categorie}', name: 'app_supprimer_produit_categorie', methods: ['GET'])]
    public function supprimerCategorie( Produit $produit ,Categorie $categorie, ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $produit->removeCategory($categorie);
        $categories=$categorie->getCategories();
        while(count($categories)>0) {
                foreach ($categories as $cat) {
                    if($produit->getCategories()->contains($cat)) {
                        $produit->removeCategory($cat);
                        $categories = $cat->getCategories();
                        break;
                    }
                }
        }
        $produitRepository->add($produit,true);
        return $this->redirectToRoute('app_produit_categories',['id'=>$produit->getId()]);
    }
}
