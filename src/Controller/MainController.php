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
        return $this->render('main/homePanel.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
