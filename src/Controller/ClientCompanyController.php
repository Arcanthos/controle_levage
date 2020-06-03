<?php

namespace App\Controller;

use App\Entity\ClientCompany;
use App\Entity\Contact;
use App\Form\ClientCompanyType;
use App\Repository\ClientCompanyRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientCompanyController extends AbstractController
{

    /**
     * @Route("/user/management-client-company", name="management_client_company")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ClientCompanyRepository $clientCompanyRepository
     * @return Response
     */
    public function managementClientCompany(Request $request, EntityManagerInterface $em, ClientCompanyRepository $clientCompanyRepository)
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

        return $this->render('client_company/managementClientCompany.html.twig',[
            'controller_name' => 'ClientCompanyController',
            'clientCompanyForm' => $clientCompanyForm->createView(),
            'clientCompanyList'=>$clientCompanyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/management-client-company/detail-client-company/{id}", name="detail_client_company", requirements={"id": "\d+"})
     * @param EntityManagerInterface $em
     * @param ClientCompanyRepository $clientCompanyRepo
     * @param $id
     * @param ContactRepository $contactRepo
     * @return Response
     */
    public function detailClientCompany(EntityManagerInterface $em, ClientCompanyRepository $clientCompanyRepo, $id, ContactRepository $contactRepo)
    {
        $clientCompanyRepo = $em->getRepository(ClientCompany::class);
        $clientCompany = $clientCompanyRepo->find($id);

        $contactRepo = $em->getRepository(Contact::class);
        $contacts = $contactRepo->findAllByCompanyId($id);

        return $this->render('client_company/detail.html.twig', [
            'clientCompany'=> $clientCompany,
            'contacts'=> $contacts,
        ]);
    }

    /**
     * @Route("/user/management-client-company/edit-client-company/{id}", name="edit_client_company", requirements={"id": "\d+"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ClientCompanyRepository $clientCompanyRepo
     * @param $id
     * @return Response
     */
    public function editClientCompany(Request $request, EntityManagerInterface $em, ClientCompanyRepository $clientCompanyRepo, $id)
    {
        dump($id);
        $clientCompany = $clientCompanyRepo->find($id);
        dump($clientCompany);
        $editClientCompanyForm = $this->createForm(ClientCompanyType::class);
        $editClientCompanyForm->handleRequest($request);

        if($editClientCompanyForm->isSubmitted()&& $editClientCompanyForm->isValid())
        {
            $em->flush();
            return $this->redirectToRoute("detail_client_company");
        }

        return $this-> render('client_company/editClientCompany.html.twig', [
            'editClientCompanyForm'=> $editClientCompanyForm->createView(),
            'clientCompany'=> $clientCompany,
        ]);
    }



}
