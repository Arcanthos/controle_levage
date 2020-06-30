<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BomCompacteurController extends AbstractController
{

    /**
     * @Route("control/bom-compacteur/periodicControl/{id}", name="bom_compacteurPeriodicControl")
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

        return $this->render('/control/bom-compacteur/periodicControl.html.twig', [
            'controller_name' => 'BomCompacteurController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }
}