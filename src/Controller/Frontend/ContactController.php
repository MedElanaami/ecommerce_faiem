<?php

namespace App\Controller\Frontend;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,MailerInterface $mailer): Response
    {
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class,array('required'=>true))
            ->add('email', EmailType::class,array('required'=>true))
            ->add('tel', TextType::class,array('required'=>true))
            ->add('message', TextareaType::class,array('required'=>true))
            ->getForm();
       $form->handleRequest($request);
       if($form->isSubmitted()&&$form->isValid())
       {
          $email=(new TemplatedEmail())
              ->from(" noreply@elanaami.com")
              ->to (new Address('elanaamimohamed@gmail.com'))
              ->subject("Email envoyé depuis le site faem.ma")
              ->htmlTemplate('frontend/emails/contact.html.twig')
              ->context(['data'=>$form->getData()]);
          $mailer->send($email);
          $this->addFlash('success','Votre message a été envoyé avec succés!!!');
           return $this->redirectToRoute('app_accueil');

       }
        return $this->renderForm('frontend/contact.html.twig',['form'=>$form]);
    }
}
