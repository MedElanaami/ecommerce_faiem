<?php

namespace App\Controller\Frontend;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blogs', name: 'app_blogs')]
    public function index(BlogRepository $blogRepository): Response
    {
        $blogs= $blogRepository->findAll();
        return $this->render('frontend/blogs.html.twig',
            ['blogs'=>$blogs]
        );
    }
    #[Route('/blogs/{id}', name: 'app_blog')]
    public function details(Blog $blog , BlogRepository $blogRepository): Response
    {
        $blogs=$blogRepository->findBy(array(),array(),4);
              return $this->render('frontend/blog.html.twig',
            ['blog'=>$blog,'blogs'=>$blogs]
        );
    }
}
