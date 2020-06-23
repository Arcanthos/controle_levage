<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CricMobileTableElevatriceController extends AbstractController
{
    /**
     * @Route("control/cricMobile_tableElevatrice_grueDAtelier/periodicControl/{controlId}/{id}", name="cricMobile_tableElevatrice_grueDAtelierPeriodicControl")
     * @param $controlId
     * @param $id
     * @param ControlRepository $controlRepository
     * @param EquipmentRepository $equipmentRepository
     * @return Response
     */
    public function periodicControl($controlId, $id, ControlRepository $controlRepository, EquipmentRepository $equipmentRepository)
    {
        $equipment = $equipmentRepository->find($id);
        $control = $controlRepository->find($controlId);
        $user = $this ->getUser();

        return $this->render('/control/cric_mobile_table_elevatrice/periodicControl.html.twig', [
            'controller_name' => 'CricMobileTableElevatriceController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }


}
