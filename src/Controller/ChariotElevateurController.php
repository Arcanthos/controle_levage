<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChariotElevateurController extends AbstractController
{
    /**
     * @Route("control/chariot_elevateur/periodicControl/{controlId}/{id}", name="chariot_elevateur_chargeur_frontalPeriodicControl")
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

        return $this->render('/control/chariot-elevateur/periodicControl.html.twig', [
            'controller_name' => 'ChariotElevateurController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }

}