<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Repository\ClientCompanyRepository;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipmentController extends AbstractController
{
    /**
     * @Route("/createEquipment/{idClientCompany}", name="createEquipment", requirements={"idClientCompany": "\d+"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $idClientCompany
     * @param ClientCompanyRepository $clientCompanyRepo
     * @return Response
     */
    public function createEquipment(Request $request, EntityManagerInterface $em, $idClientCompany, ClientCompanyRepository $clientCompanyRepo)
    {
        //initialisation du formulaire de création d'un nouvel équipement
        $equipment = new Equipment();
        $equipmentForm = $this->createForm(EquipmentType::class, $equipment);

        //persistance du nouvel équipement
        $equipmentForm->handleRequest($request);
        if ($equipmentForm->isSubmitted()&& $equipmentForm->isValid())
        {
            //Récupération de la société cliente
            $equipment->setEquipmentCategory($equipment->getSubcategory()->getParentCategory());
            $equipment->setClientCompany($clientCompanyRepo->find($idClientCompany));

            $em->persist($equipment);
            $em->flush();

            $this->addFlash('success','Le nouvel équipement est enregistré');
            return $this->redirectToRoute('detail_client_company', [
                'id'=>$idClientCompany,
            ]);
        }

        return $this->render('equipment/createEquipment.html.twig', [
            'controller_name' => 'EquipmentController',
            'equipmentForm'=>$equipmentForm->createView(),
            'id'=>$idClientCompany,
        ]);
    }

    /**
     * @Route("/delete-equipment/{id}", name="delete_equipment", requirements={"id": "\d+"})
     * @param EntityManagerInterface $em
     * @param EquipmentRepository $equipmentRepo
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEquipment(EntityManagerInterface $em, EquipmentRepository $equipmentRepo, $id)
    {
        //Récupération de l'équipement à supprimer
        $equipment= $equipmentRepo->find($id);

        //Récupération de la société cliente qui possède l'équipement
        $idCompany = $equipment->getClientCompany()->getId();

        //Suppression en BDD
        $em->remove($equipment);
        $em->flush();

        $this->addFlash('success', " L'équipement a bien été supprimé");

        return $this->redirectToRoute('detail_client_company', [
            'id'=>$idCompany,
        ]);
    }

    /**
     * @Route("/detail-equipment/{id}", name="detail_equipment", requirements={"id": "\d+"})
     * @param EntityManagerInterface $em
     * @param EquipmentRepository $equipmentRepo
     * @param $id
     * @return Response
     */
    public function detailEquipment(EntityManagerInterface $em, EquipmentRepository $equipmentRepo, $id)
    {
        //Récupération de tous les éléments d'un équipement
        $equipmentRepo = $em->getRepository(Equipment::class);
        $equipment = $equipmentRepo->find($id);

        return $this->render('equipment/detailEquipment.html.twig', [
            'equipment'=> $equipment,
        ]);
    }


    //TODO: pour l'update, il faudra que le controle soit fait afin de récupérer les dates du précédent contrôle et de prévoir le prochain
}
