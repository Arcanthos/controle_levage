<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BrasDeLevageController extends AbstractController
{
    /**
     * @Route("/bras/de/levage", name="bras_de_levage")
     */
    public function index()
    {
        return $this->render('control/bras_de_levage/index.html.twig', [
            'controller_name' => 'BrasDeLevageController',
        ]);
    }
}
