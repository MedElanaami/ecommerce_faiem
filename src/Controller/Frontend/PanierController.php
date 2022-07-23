<?php

namespace App\Controller\Frontend;

use App\Repository\CouponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $data=[];
            if($coupon ) {

               $session->set("codeCoupon",$coupon->getId());
               $produitController->setPrixTotal($request,$couponRepository);
                $data['status']=200;
                $data['message']="Le code coupon a été appliqué avec succées";

            }
            else
            {
                $data['status']=403;
                $data['message']="Désolé le code coupon que vous avez entré est incorrecte";
            }
            $data['prix']=$session->get('prixTotal');
            return new JsonResponse($data);
        }
        return $this->renderForm('frontend/panier.html.twig', ['formCoupon'=>$form]);
    }
}
