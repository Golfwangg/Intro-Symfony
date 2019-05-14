<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'owner' => 'Golfwang',
        ]);
    }

    /**
     * @Route("/show/{slug<^[a-z0-9-]+$>?Article Sans Titre}", name="show")
     *
     */
    public function show($slug)
    {
        $slug = str_replace('-', ' ', $slug);
        $slug = ucwords($slug);
        return $this->render('blog/show.html.twig', [
            "slug" => $slug
        ]);
    }
}
