<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Article;
use App\Entity\Category;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @Route("/show/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     * @param string $slug The slugger
     * @return Response A response instance
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.'
            );
        }

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'slug' => $slug,
        ]);
    }

    /**
     * @Route("/category/{name}",
     *     defaults={"category" = null},
     *      name="show_category")
     * @param Category $category
     * @return Response A response instance
     */
    public function showByCategory(Category $category): Response
    {
        /*if (!$category) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $category = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($category)), "-")
        );

        $category = $this->getDoctrine()
            ->getRepository(CategoryController::class)
            ->findOneBy(['name' => $category]);

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' => $category], ['id' => 'DESC'], 3);

        if (!$category) {
            throw $this->createNotFoundException(
                'No articles with ' . $category . ' title, found in article\'s table.'
            );
        }*/

        return $this->render('blog/category.html.twig', [
            'category' => $category,
            'articles' => $category->getArticles(),
        ]);
    }
}
