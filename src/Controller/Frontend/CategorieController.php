<?php

namespace App\Controller\Frontend;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{slug}', name: 'app_categorie', options: ['expose' => true])]
    public function index(Request $request, Categorie $categorie, ProduitRepository $produitRepository, CategorieRepository $categorieRepository, PaginatorInterface $paginator): Response
    {
        if ($request->isXmlHttpRequest()) {
            $filterSelect = $request->get('filterSelect');
            $nbrProduits = $request->get('nbrProduits');
            $page = $request->get('page');

            if ($page and !$filterSelect) {

                $produits = $paginator->paginate(
                    $categorie->getProduits(), // Requête contenant les données à paginer (ici nos articles)
                    $request->query->getInt('page', $page), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                    4// Nombre de résultats par page
                );
            }
            if ($nbrProduits and !$filterSelect) {
                $produits = $paginator->paginate(
                    $categorie->getProduits(), // Requête contenant les données à paginer (ici nos articles)
                    $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                    $nbrProduits // Nombre de résultats par page
                );
            }
            if ($filterSelect) {

                if ($filterSelect == 1)
                    $produits = $paginator->paginate(
                        $produitRepository->selectParPrixDescendant($categorie), // Requête contenant les données à paginer (ici nos articles)
                        $request->query->getInt('page', $page), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                        4 // Nombre de résultats par page
                    );
                else if ($filterSelect == 2)
                    $produits = $paginator->paginate(
                        $produitRepository->selectParPrixAscendant($categorie), // Requête contenant les données à paginer (ici nos articles)
                        $request->query->getInt('page', $page), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                        4 // Nombre de résultats par page
                    );
                else if ($filterSelect == 3)
                    $produits = $paginator->paginate(
                        $produitRepository->selectParPromo($categorie), // Requête contenant les données à paginer (ici nos articles)
                        $request->query->getInt('page', $page), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                        4 // Nombre de résultats par page
                    );
                else
                {

                    $produits = $paginator->paginate(
                        $categorie->getProduits(), // Requête contenant les données à paginer (ici nos articles)
                        $request->query->getInt('page', $page), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                        4
                    );
                }
            }
            return new JsonResponse(['content' => $this->renderView('frontend/layouts/produits_categorie.html.twig', ['produits' => $produits])]);
        }
        $produits = $paginator->paginate(
            $categorie->getProduits(), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('frontend/categorie.html.twig',
            ['categorie' => $categorie, 'produits' => $produits]
        );


    }
}
