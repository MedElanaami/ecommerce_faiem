<?php
//src/Twig/AppExtension.php
namespace App\Twig;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    public FormFactory $formFactory;
    public FormInterface $formInterface;
    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('formNewsletter', [$this, 'formNewsletter']),
        ];
    }

    public function formNewsletter()
    {

        $newsletter = new Newsletter();
        $form = $this->formFactory->create(NewsletterType::class, $newsletter);
        return $form->createView();
    }
}
