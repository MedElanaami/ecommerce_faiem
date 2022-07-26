<?php

namespace App\Controller\Backend;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/admin/notification', name: 'notifications', options: ['expose' => true])]
    public function notifications(Request $request , CommandeRepository $commandeRepository): Response
    {
        if($request->isXmlHttpRequest()){
            $commandes=$commandeRepository->findBy(['vu'=>false]);
            $data=[];
            foreach ($commandes as $commande){
                $data[] = ['nom' => $commande->getClient()->getNom(), 'prenom' => $commande->getClient()->getPrenom(),
                    'id_client' => $commande->getClient()->getId(),
                    'id_cmd' => $commande->getId()
                ];
            }
            return new JsonResponse($data );
        }
        return $this->redirectToRoute("admin_accueil");
    }
}
