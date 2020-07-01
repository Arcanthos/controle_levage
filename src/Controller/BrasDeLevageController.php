<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrasDeLevageController extends AbstractController
{
    /**
     * @Route("control/bras-de-levage/periodicControl/{id}", name="bras_de_levagePeriodicControl")
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

        return $this->render('control/bras_de_levage/periodicControl.html.twig', [
            'controller_name' => 'BrasDeLevageController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }


    /**
     * @Route("control/bras-de-levage/CommissioningControl/{id}", name="bras_de_levageCommissioningControl")
     */
    public function controleMiseEnService($id)
    {
        return $this->render('control/bras_de_levage/commissioningControl.html.twig', [
            'controller_name' => 'BrasDeLevageController',
        ]);
    }


    /**
     * @Route("control/bras-de-levage/ReturnToServiceControl/{id}", name="bras_de_levageReturnToServiceControl")
     */
    public function controleRemiseEnService($id)
    {
        return $this->render('control/bras_de_levage/returnToServiceControl.html.twig', [
            'controller_name' => 'BrasDeLevageController',
        ]);
    }
}
