<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeSurPisteController extends AbstractController
{
    /**
     * @Route("control/vehicule_sur_piste/periodicControl/{controlId}/{id}", name="vehicule_sur_pistePeriodicControl")
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

        return $this->render('/control/vehicule-sur-piste/periodicControl.html.twig', [
            'controller_name' => 'VehiculeSurPisteController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }
}