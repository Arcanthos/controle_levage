<?php

namespace App\Controller;

use App\Entity\ClientCompany;
use App\Entity\Contact;
use App\Entity\Equipment;
use App\Form\ClientCompanyType;
use App\Repository\ClientCompanyRepository;
use App\Repository\ContactRepository;
use App\Repository\EquipmentRepository;
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

            //clear des champs du formulaire0
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
     * @param EquipmentRepository $equipmentRepo
     * @return Response
     */
    public function detailClientCompany(EntityManagerInterface $em, ClientCompanyRepository $clientCompanyRepo, $id,
                                        ContactRepository $contactRepo, EquipmentRepository $equipmentRepo)
    {
        $clientCompanyRepo = $em->getRepository(ClientCompany::class);
        $clientCompany = $clientCompanyRepo->find($id);

        //Récupération de tous les contacts de la société par son id
        $contactRepo = $em->getRepository(Contact::class);
        $contacts = $contactRepo->findAllByCompanyId($id);

        //Récupération de la liste du matériel de la société par son id
        $equipmentRepo = $em->getRepository(Equipment::class);
        $equipments = $equipmentRepo->findAllEquipmentByCompany($id);

        return $this->render('client_company/detail.html.twig', [
            'clientCompany'=> $clientCompany,
            'contacts'=> $contacts,
            'equipments'=> $equipments,
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
        $clientCompany = $clientCompanyRepo->find($id);

        $editClientCompanyForm = $this->createForm(ClientCompanyType::class, $clientCompany);
        $editClientCompanyForm->handleRequest($request);

        if($editClientCompanyForm->isSubmitted()&& $editClientCompanyForm->isValid())
        {
            $em->flush();
            return $this->redirectToRoute("detail_client_company",[
                'id'=>$clientCompany->getId(),
            ]);
        }

        return $this-> render('client_company/editClientCompany.html.twig', [
            'editClientCompanyForm'=> $editClientCompanyForm->createView(),
            'clientCompany'=> $clientCompany,
        ]);
    }

    /**
     * @Route("/user/delete-client-company/{id}", name="delete_client_company", requirements={"id": "\d+"})
     * @param EntityManagerInterface $em
     * @param ClientCompanyRepository $clientCompanyRepo
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteClientCompany(EntityManagerInterface $em, ClientCompanyRepository $clientCompanyRepo, $id)
    {
        $clientCompany = $clientCompanyRepo->find($id);
        $em->remove($clientCompany);
        $em->flush();
        $this->addFlash('success', 'La société cliente a bien été supprimée');
        return $this->redirectToRoute('management_client_company');
    }

}
