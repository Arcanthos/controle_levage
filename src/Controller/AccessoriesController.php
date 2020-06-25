<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccessoriesController extends AbstractController
{
    /**
     * @Route("control/accessoires", name="accessoiresControl")
     *
     */
    public function control()
    {
        $user = $this ->getUser();

        return $this->render('control/accessories/control.html.twig', [
            'controller_name' => 'AccessoriesController',
            'user'=>$user,
        ]);
    }
}
