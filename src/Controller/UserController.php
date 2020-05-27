<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/new-user", name="newUser")
     */
    public function nouvelleUtilisateur()
    {


        return $this->render('user/newUser.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }



}
