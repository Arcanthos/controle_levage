<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
