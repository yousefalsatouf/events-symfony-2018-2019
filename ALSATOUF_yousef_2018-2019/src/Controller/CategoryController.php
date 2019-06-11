<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/Categories", name="categories_list")
     */
    public function category(CategoryRepository $repository)
    {
        $category = $repository->findAll();

        return $this->render('category/category.html.twig', [
            'title' => 'CATEGORY',
            'categories'=> $category
        ]);
    }
}
