<?php

namespace App\Controller;

use App\Entity\ClientCompany;
use App\Form\ClientCompanyType;
use App\Repository\ClientCompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientCompanyController extends AbstractController
{

    /**
     * @Route("/user/create-client-company", name="create_client_company")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ClientCompanyRepository $clientCompanyRepository
     * @return Response
     */
    public function createClientCompany(Request $request, EntityManagerInterface $em, ClientCompanyRepository $clientCompanyRepository)
    {
        //création d'un nouveau formulaire d'ajout d'une nouvelle société cliente
        $clientCompany = new ClientCompany();
        $clientCompanyForm = $this->createForm(ClientCompanyType::class, $clientCompany);
        $clientCompanyForm->handleRequest($request);

        //persistance de la nouvelle société cliente
        if($clientCompanyForm->isSubmitted()&& $clientCompanyForm->isValid())
        {
            //Remplissage du champ controlCompany avec l'utilisateur connecté
            $clientCompany->setControlCompany($this->getUser()->getCompany());

            $em->persist($clientCompany);
            $em->flush();

            $this->addFlash('success','La société est enregistrée');

            //clear des champs du formulaire
            unset($clientCompany);
            unset($clientCompanyForm);
            $clientCompany = new ClientCompany();
            $clientCompanyForm = $this->createForm(ClientCompanyType::class, $clientCompany);
        }

        return $this->render('client_company/createClientCompany.html.twig',[
            'controller_name' => 'ClientCompanyController',
            'clientCompanyForm' => $clientCompanyForm->createView(),
            'clientCompanyList'=>$clientCompanyRepository->findAll(),
        ]);
    }


}
