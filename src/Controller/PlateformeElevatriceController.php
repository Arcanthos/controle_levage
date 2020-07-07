<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlateformeElevatriceController extends AbstractController
{
    /**
     * @Route("control/plateforme_elevatrice/periodicControl/{controlId}/{id}", name="plateforme_elevatricePeriodicControl")
     * @param $controlId
     * @param $id
     * @param ControlRepository $controlRepository
     * @param EquipmentRepository $equipmentRepository
     * @return Response
     */
    public function controlePeriodique($controlId, $id, ControlRepository $controlRepository, EquipmentRepository $equipmentRepository)
    {
        $equipment = $equipmentRepository->find($id);
        $control = $controlRepository->find($controlId);
        $user = $this ->getUser();

        return $this->render('/control/plateforme-elevatrice/periodicControl.html.twig', [
            'controller_name' => 'PlateformeElevatriceController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }
}