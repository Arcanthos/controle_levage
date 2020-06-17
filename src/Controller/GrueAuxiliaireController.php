<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GrueAuxiliaireController extends AbstractController
{
    /**
     * @Route("control/grue_auxiliaire/{controlId}/{id}", name="grue_auxiliairePeriodicControl")
     * @param $controlId
     * @param $id
     * @param ControlRepository $controlRepository
     * @param EquipmentRepository $equipmentRepository
     * @return Response
     */
    public function periodicControl($controlId, $id,ControlRepository $controlRepository, EquipmentRepository $equipmentRepository)
    {
        $equipment = $equipmentRepository->find($id);
        $control = $controlRepository->find($controlId);
        $user = $this ->getUser();

        return $this->render('/control/grue_auxiliaire/periodicControl.html.twig', [
            'controller_name' => 'GrueAuxiliaireController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }

    /**
     * @Route("control/grue_auxiliaire/{controlId}/{id}", name="grue_auxiliaireCommissioningControl")
     * @param $controlId
     * @param $id
     * @param ControlRepository $controlRepository
     * @param EquipmentRepository $equipmentRepository
     * @return Response
     */
    public function commissioningControl($controlId, $id, ControlRepository $controlRepository, EquipmentRepository $equipmentRepository)
    {
        $equipment = $equipmentRepository->find($id);
        $control = $controlRepository->find($controlId);
        $user = $this ->getUser();

        return $this->render('/control/grue_auxiliaire/commissioningControl.html.twig', [
            'controller_name' => 'GrueAuxiliaireController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }

    /**
     * @Route("control/grue_auxiliaire/{controlId}/{id}", name="grue_auxiliaireReturnToServiceControl")
     * @param $controlId
     * @param $id
     * @param ControlRepository $controlRepository
     * @param EquipmentRepository $equipmentRepository
     * @return Response
     */
    public function returnToServiceControl($controlId, $id, ControlRepository $controlRepository, EquipmentRepository $equipmentRepository)
    {
        $equipment = $equipmentRepository->find($id);
        $control = $controlRepository->find($controlId);
        $user = $this ->getUser();

        return $this->render('/control/grue_auxiliaire/returnToServiceControl.html.twig', [
            'controller_name' => 'GrueAuxiliaireController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }
}
