<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElevateurDeVehiculesController extends AbstractController
{
    /**
     * @Route("control/elevateur-de-vehicules/periodicControl/{id}", name="elevateur_de_vehiculesPeriodicControl")
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

        return $this->render('/control/elevateur-de-vehicules/periodicControl.html.twig', [
            'controller_name' => 'ElevateurDeVehiculesController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }
}