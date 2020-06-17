<?php

namespace App\Controller;

use App\Entity\Control;
use App\Entity\Equipment;
use App\Form\ControlType;
use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControlController extends AbstractController
{
    /**
     * @Route("/create-control/{id}", name="create_control", requirements={"id": "\d+"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $id
     * @param EquipmentRepository $equipmentRepo
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function createControl(Request $request, EntityManagerInterface $em, $id, EquipmentRepository $equipmentRepo)
    {
        //Récupération des informations concernant l'équipement contrôlé
        $equipmentRepo = $em->getRepository(Equipment::class);
        $equipment = $equipmentRepo->find($id);

        $user= $this->getUser();
        //initialisation du formulaire de création d'un nouveau contrôle
        $control = new Control();
        $controlForm = $this->createForm(ControlType::class, $control);


        $controlForm->handleRequest($request);
        if($controlForm->isSubmitted() && $controlForm->isValid())
        {
            $control->setControlEquipment($equipment);
            //Récupération de la date du jour
            $date = new \DateTime();
            $control->setDate(clone $date);

            //ainsi que la date du prochain contrôle dans 6 Mois
            $interval = new \DateInterval('P6M');
            $dateNextControl = $date->add($interval);
            $control->setDateNextControl($dateNextControl);

            //persistance du nouveau contrôle
            $em->persist($control);
            $em->flush();

            return $this->redirectToRoute($equipment->getEquipmentCategory()->getAlias(), [
                'equipmentId'=>$id,
                'controlId'=>strval($control->getId()),
                'userId'=>strval($user->getId()),
            ]);
        }

        return $this->render('control/createControl.html.twig', [
            'controller_name' => 'ControlController',
            'controlForm'=> $controlForm->createView(),
            'equipment'=> $equipment,
            'control'=> $control,
            'user'=> $user,
        ]);
    }

    /**
     * @Route("/start-control", name="startControl")
     * @param Request $request
     * @param ControlRepository $controlRepository
     * @return Response
     */
    public function startControl(Request $request, ControlRepository $controlRepository){

        $controlsToDo = $controlRepository->controlIsNotDone();


        return $this->render('control/startControl.html.twig',[
            'controlsToDo'=>$controlsToDo
        ]);
    }


    /**
     * @Route("/add-control", name="addControl")
     * @param EquipmentRepository $equipmentRepository
     * @return Response
     */
    public function addControl(EquipmentRepository $equipmentRepository){
        $controlCompany = $this->getUser()->getCompany();
        $controlCompanyId = $controlCompany->getId();
        $allEquipments = $equipmentRepository->findAllEquipmentByCompanyControlCompany($controlCompanyId);
        $equipmentToControl = [];
/*
        foreach ($allEquipments as $equipment){

            if (empty($equipment->getControls()) or date_diff(($equipment->getControls()->last()->getDate())+new \DateInterval('P10M'))->format("d/m/Y H:i")), new \DateTime()) > ){
                array_push($equipmentToControl, $equipment);
            }

        }
*/

        return $this->render('control/addControl.html.twig',[
            "equipmentToControl"=>$equipmentToControl
        ]);
    }

}
