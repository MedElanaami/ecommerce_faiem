<?php

namespace App\Controller\Backend;

use App\Entity\Client;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/admin', name: 'admin_accueil')]
    public function adminAccueil(Request $request,EntityManagerInterface $em ): Response
    {

        $form = $this->container->get('form.factory')->createBuilder()
            ->setMethod('POST')
            ->add(
                'dateDebut',
                DateType::class,
                [
                    'widget' => 'single_text',

                ]
            )
            ->add(
                'dateFin',
                DateType::class,
                [
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'valider',
                SubmitType::class,
                array(
                    'attr' => array(
                        'class' => 'btn btn-success',
                    ),
                )
            )
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dateDebut = $form->getData()['dateDebut'];
            $dateFin = $form->getData()['dateFin'];

        } else {

            $dateDebut = null;
            $dateFin = null;
        }

        $nbrClients = $em->getRepository(Client::class)->nbrClients($dateDebut, $dateFin);
        $cmdConfirmee = $em->getRepository(Commande::class)->cmdConfirmee($dateDebut, $dateFin);
        $nbrCmds = $em->getRepository(Commande::class)->nbrCmds($dateDebut, $dateFin);
        $cmdAnnulee= $em->getRepository(Commande::class)->cmdAnnulee($dateDebut, $dateFin);
        $cmdsStats=array();
        $mois=['janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
        $montantByMonthAndYear=array();
        for($i = 2022; $i <= 2023; $i++)
        {
            for($j=1;$j<=12;$j++)
            {
                $montantByMonthAndYear[$j-1]['mois']=$mois[$j-1];
                if( $em->getRepository(Commande::class)->montantByMonthAndYear($j,$i)==null)
                $montantByMonthAndYear[$j-1]['montant']=0;
                else
                    $montantByMonthAndYear[$j-1]['montant'] =$em->getRepository(Commande::class)->montantByMonthAndYear($j,$i);
                ;            }
            $cmdsStats[$i]=$montantByMonthAndYear;

        }

        for($i = 1; $i <= 12; $i++)
        {
            $clientsCmdsStats[$i-1]['mois']=$mois[$i-1];
            $clientsCmdsStats[$i-1]['client']=$em->getRepository(Client::class)->clientByMonthAndYear($i,2022);
            $clientsCmdsStats[$i-1]['commande']=$em->getRepository(Commande::class)->cmdByMonthAndYear($i,2022);
        }
        return $this->render('backend/accueil/index.html.twig', array(
            "form" => $form->createView(),
            'nbrClients' => $nbrClients,
            'cmdConfirmee' => $cmdConfirmee,
            'cmdAnnulee'=>$cmdAnnulee,
            'nbrCmds'=>$nbrCmds,
            'cmdsStats'=>json_encode($cmdsStats),
            'clientsCmdsStats'=>json_encode($clientsCmdsStats),

        ));

    }
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
