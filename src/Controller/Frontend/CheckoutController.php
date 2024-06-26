<?php

namespace App\Controller\Frontend;


use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Coupon;
use App\Entity\LigneCommande;
use App\Entity\Produit;
use App\Entity\Status;
use App\Entity\Ville;
use App\Form\RegistrationClientType;


use App\Repository\CommandeRepository;
use App\Repository\ParametreRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CheckoutController extends AbstractController
{


    public function __construct(public RequestStack $request, public ParametreRepository $parametreRepository)
    {
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Security $security, MailerInterface $mailer): Response
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

                $typePaiement=$request->get('payment_method');
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
                $commande->setTypePaiement($typePaiement);
                $commande->setClient($user);
                $commande->setPrixLivraison($session->get('prixLivraison'));
                $commande->setPrixTotal($session->get('prixTotal'));
                if ($session->get('codeCoupon')) {
                    $coupon = $entityManager->getRepository(Coupon::class)->find($session->get('codeCoupon'));
                    if ($coupon) {
                        $commande->setCoupon($coupon);
                        $commande->setCouponApplique(true);
                    }
                }
                $status=$entityManager->getRepository(Status::class)->find(1);
                if ($status)
                $commande->setStatus($status);
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
                        $commande->addLigneCommande($ligneCommande);
                        $entityManager->flush();
                    }
                }
                $entityManager->persist($commande);
                $entityManager->flush();
                $session->remove('produits');
                $session->remove('prixTotal');
                $session->remove('codeCoupon');
                $session->remove('prixLivraison');
                $email = (new TemplatedEmail())
                    ->from(" noreply@faem.ma")
                    ->to(new Address('commande@faem.ma'))
                    ->subject("Nouvelle commande depuis le site faem.ma")
                    ->htmlTemplate('frontend/emails/commande.html.twig')
                    ->context(['commande' => $commande]);
               $mailer->send($email);
                if( $typePaiement==2) {
                    $req_url = 'https://api.exchangerate-api.com/v4/latest/MAD';
                    $response_json = file_get_contents($req_url);
                    $prixEnMAD = $commande->getPrixTotal()+$commande->getPrixLivraison();
                    if(false !== $response_json) {

                        // Try/catch for json_decode operation
                        try {

                            // Decoding
                            $response_object = json_decode($response_json);

                            // YOUR APPLICATION CODE HERE, e.g.
                           // Your price in MAD
                            $prixEnUSD = round(($prixEnMAD * $response_object->rates->USD), 0);

                        }
                        catch(\Exception $e) {

                        }
                    }
                    else{
                        $prixEnUSD=$prixEnMAD*0.0941;
                    }
                    return $this->render('frontend/paypal.html.twig', ['commande' => $commande,'prix'=>$prixEnUSD]);
                }$this->addFlash('success', 'Votre commande a été bien enregistrée, nous vous contacterons le plus tôt possible.');
                return $this->redirectToRoute("app_accueil");
            }

            return $this->render('frontend/checkout.html.twig', ['form' => $form->createView()]);
        } else {
            return $this->redirectToRoute("app_accueil");

        }
    }

    #[Route('/prixLivraison', name: 'app_prix_livraison')]
    public function prixLivrasion(Request $request, ParametreRepository $parametreRepository, VilleRepository $villeRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $idVille = $request->get("id_ville");
            $ville = $villeRepository->find($idVille);
            $this->getPrixLivraison($ville);
            return new JsonResponse($this->getPrixLivraison($ville));
        }
        return $this->redirectToRoute("app_accueil");

    }

    #[Route('/payement', name: 'payment_success')]
    public function payementSuccess(Request $request, CommandeRepository $commandeRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $commandeId = $request->get("commande");
            $commande =$commandeRepository->find($commandeId);
            if( $commande)
            {   $commande->setPayee(true);
                $commandeRepository->add($commande,true);
                $this->addFlash('success', 'Votre commande a été bien enregistrée, nous vous contacterons le plus tôt possible.');
            }
            return new JsonResponse("success");
        }
        return $this->redirectToRoute("app_accueil");

    }

    public function getPrixLivraison(Ville $ville=null)
    {
        $prixLivraison = 0;
        if($ville) {
            $parametre = $this->parametreRepository->findOneBy(array());
            if ($ville->getLivraison()) {
                if ($parametre && $parametre->getSeuilLivraison()) {
                    if ($this->request->getSession()->get('prixTotal') >= $parametre->getSeuilLivraison())
                        $prixLivraison = 0;
                    else
                        $prixLivraison = $ville->getLivraison()->getPrix();
                } else {
                    $prixLivraison = $ville->getLivraison()->getPrix();
                }
            }
        }
        $this->request->getSession()->set('prixLivraison', $prixLivraison);
        return $prixLivraison;
    }
}