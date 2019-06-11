<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Event;
use App\Form\CategoryType;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/form/event/insert", name="insert_event")
     * @Route("/form/event/edit/{id}", name="edit_event")
     */
    public function eventForm(Request $request, Event $event = null)
    {

        if(!$event){
            $event = new Event();
        }

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($event);
            $manager->flush();

            return $this->redirectToRoute('events_list');
        }

        return $this->render('form/eventForm.html.twig', [
            'title' => 'CREATE/EDIT',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/form/category/insert", name="insert_category")
     */
    public function categoryForm(Request $request, Category $category = null)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('categories_list');
        }

        return $this->render('form/categoryForm.html.twig', [
            'title' => 'CREATE CATEGORY',
            'form' => $form->createView()
        ]);
    }
}
