<?php
//src/Twig/AppExtension.php
namespace App\Twig;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\CategorieRepository;
use App\Repository\ParametreRepository;
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
    public CategorieRepository $categorieRepository;
    public ParametreRepository $parametreRepository;
    public function __construct(FormFactory $formFactory,CategorieRepository $categorieRepository, ParametreRepository $parametreRepository)
    {
        $this->formFactory = $formFactory;
        $this->categorieRepository=$categorieRepository;
        $this->parametreRepository=$parametreRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('formNewsletter', [$this, 'formNewsletter']),
            new TwigFunction('categories', [$this, 'categories']),
            new TwigFunction('parametre', [$this, 'parametre']),
        ];
    }

    public function formNewsletter()
    {

        $newsletter = new Newsletter();
        $form = $this->formFactory->create(NewsletterType::class, $newsletter);
        return $form->createView();
    }
    public function categories()
    {
        $categories=$this->categorieRepository->findBy(array('parent'=>NULL));
        return $categories;
    }public function parametre()
    {
        $parametre=$this->parametreRepository->findOneBy(array());
        return $parametre;
    }
}
