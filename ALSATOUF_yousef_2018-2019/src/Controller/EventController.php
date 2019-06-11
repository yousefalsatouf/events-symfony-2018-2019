<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/", name="events_list")
     */
    public function home(EventRepository $repository)
    {
        $events = $repository->findAll();

        return $this->render('event/events.html.twig', [
            'title' => 'HOME',
            'events'=> $events
        ]);
    }

    /**
     * @Route("/event/{id}", name="details")
     */

    public function eventDetails(Event $event, EventRepository $repository){
        $event =  $repository->find($event);
        //dump($cocktail);

        return $this->render('event/eventDetails.html.twig', [
            'title'=> 'DETAILS',
            'event' => $event
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove_event")
     */

    public function removeCocktail(Event $event){

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($event);
        $manager->flush();

        return $this->redirectToRoute('events_list');
    }

}
