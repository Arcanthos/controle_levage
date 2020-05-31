<?php

namespace App\Controller;

use App\Entity\ControlCompany;
use App\Form\ControlCompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControlCompanyController extends AbstractController
{
    /**
     * @Route("/control-company-management", name="control_company")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function companyManagement(Request $request , EntityManagerInterface $entityManager)
    {
        //initialisation du formulaire de création de sociétés clientes, à qui nous pouvons vendre le programme
        $company = new ControlCompany();
        $companyForm = $this->createForm(ControlCompanyType::class, $company);

        //si la société instancié est la première instancié, elle devient la société principale de l'application
        $companyRepo = $entityManager->getRepository(ControlCompany::class);
        $allCompany = $companyRepo->findAll();
        if (count($allCompany) >= 1 ){
            $company->setIsMasterCompany(false);
        }else{
            $company->setIsMasterCompany(true);
        }

        //persistance de la nouvelle instance de société de controle
        $companyForm->handleRequest($request);
        if ($companyForm->isSubmitted() && $companyForm->isValid()){

            $entityManager->persist($company);
            $entityManager->flush();
        }
        return $this->render('control_company/newControlCompany.html.twig', [
            'controller_name' => 'ControlCompanyController',
            'newCompanyForm' => $companyForm->createView()
        ]);
    }
}
