<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="homePanel")
     */
    public function home()
    {
        if ($this->getUser() == null){
            return $this->redirectToRoute('login');
        }


        return $this->render('main/homePanel.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    /**
     * @Route("/calendar", name="control_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('main/calendar.html.twig');
    }
}
