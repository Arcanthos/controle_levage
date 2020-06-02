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
        //appel du repo controlCompany
        $companyRepo = $entityManager->getRepository(ControlCompany::class);

        //initialisation du formulaire de mise à jour de notre société
        //on appelle le user courant
        $grantedUser = $this->getUser();
        //on récupéere l'id de la company de l'user courant
        $grantedUserCompany = $grantedUser->getCompany();
        $companyId = $grantedUserCompany->getId();

        //on met à jour la company
        $companyToUpdate = $companyRepo->find($companyId);
        $updateCompanyForm = $this->createForm(ControlCompanyType::class, $companyToUpdate);
        $updateCompanyForm->handleRequest($request);
        if ($updateCompanyForm->isSubmitted() && $updateCompanyForm->isValid()){
            $companyToUpdate = $updateCompanyForm->getData();

            $entityManager->persist($companyToUpdate);
            $entityManager->flush();

            $this->addFlash('success', 'Infos de la société mise à jour !');
            return $this->redirectToRoute("control_company");
        }

        //initialisation du formulaire de création de sociétés clientes, à qui nous pouvons vendre le programme
        $company = new ControlCompany();
        $companyForm = $this->createForm(ControlCompanyType::class, $company);

        //si la société instancié est la première instancié, elle devient la société principale de l'application

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
            'companyList'=>$allCompany,
            'userCompany' =>$grantedUserCompany,
            'newCompanyForm' => $companyForm->createView(),
            'updateMainCompanyForm'=>$updateCompanyForm->createView(),
            'userGrantedCompanyId'=>$companyId
        ]);
    }
}
