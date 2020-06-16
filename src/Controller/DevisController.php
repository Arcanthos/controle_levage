<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DevisController extends AbstractController
{
    /**
     * @Route("/new-devis", name="newDevis")
     */
    public function newDevis()
    {


        return $this->render('devis/new.html.twig', [
            'controller_name' => 'DevisController',
        ]);
    }
}
