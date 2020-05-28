<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientCompanyController extends AbstractController
{
    /**
     * @Route("/client/company", name="client_company")
     */
    public function index()
    {
        return $this->render('client_company/createClientCompany.html.twig', [
            'controller_name' => 'ClientCompanyController',
        ]);
    }
}
