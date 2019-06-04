<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="add_category")
     * @param Request $request
     * @return Response A response instance
     */
    public function add(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($category);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('blog/addCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}