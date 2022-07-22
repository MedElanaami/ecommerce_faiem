<?php

namespace App\Controller\Frontend;

use App\Repository\CouponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request,CouponRepository $couponRepository,ProduitController $produitController): Response
    {

        $form=$this->createFormBuilder()
            ->add('coupon',TextType::class,['required'=>true])->getForm();
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid())
        {
            $coupon=$couponRepository->findOneBy(['code'=>$form->getData()['coupon']]);
            $session=$request->getSession();
            if($coupon ) {
               $session->set("codeCoupon",$coupon->getId());
               $produitController->setPrixTotal($request,$couponRepository);

            }
            return $this->redirect($request->headers->get('referer'));
        }
        return $this->renderForm('frontend/panier.html.twig', ['formCoupon'=>$form


        ]);
    }
}
