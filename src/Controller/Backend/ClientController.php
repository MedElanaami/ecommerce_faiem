<?php

namespace App\Controller\Backend;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'admin_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('backend/client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }
    #[Route('/{id}/delete', name: 'admin_client_delete', methods: ['GET'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository): Response
    {$clientRepository->remove($client,true);

        return $this->redirectToRoute('admin_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
