<?php

namespace App\Controller\Frontend;

use App\Repository\ParametreRepository;
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
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,MailerInterface $mailer, ParametreRepository $parametreRepository): Response
    {
        $parametre=$parametreRepository->findOneBy(array());
        if($parametre && $parametre->getEmail() )
            $email=$parametre->getEmail();
        else
            $email='contact@faem.ma';
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class,array('required'=>true))
            ->add('email', EmailType::class,array('required'=>true))
            ->add('tel', TextType::class,array('required'=>true))
            ->add('message', TextareaType::class,array('required'=>true))
            ->add("recaptcha", ReCaptchaType::class)
            ->getForm();
       $form->handleRequest($request);
       if($form->isSubmitted()&&$form->isValid())
       {

          $email=(new TemplatedEmail())
              ->from(" noreply@faem.ma")
              ->to (new Address($email))
              ->subject("Email envoyé depuis votre site ")
              ->htmlTemplate('frontend/emails/contact.html.twig')
              ->context(['data'=>$form->getData()]);
          $mailer->send($email);
          $this->addFlash('success','Votre message a été envoyé avec succés!!!');
           return $this->redirectToRoute('app_accueil');

       }
        return $this->renderForm('frontend/contact.html.twig',['form'=>$form]);
    }
}
