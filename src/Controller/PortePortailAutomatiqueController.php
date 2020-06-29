<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortePortailAutomatiqueController extends AbstractController
{
    /**
     * @Route("control/porte-portail-automatique/periodicControl/{id}", name="porte_portail_automatiquePeriodicControl")
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

        return $this->render('/control/porte-portail-automatique/periodicControl.html.twig', [
            'controller_name' => 'PortePortailAutomatiqueController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }

}