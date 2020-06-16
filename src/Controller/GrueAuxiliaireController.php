<?php

namespace App\Controller;

use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GrueAuxiliaireController extends AbstractController
{
    /**
     * @Route("/grue_auxiliaire/{equipmentId}/{controlId}/{userId}", name="grue_auxiliaire")
     * @param $controlId
     * @param $equipmentId
     * @param $userId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($controlId, $equipmentId, $userId, ControlRepository $controlRepository, UserRepository $userRepository, EquipmentRepository $equipmentRepository)
    {
        $control = $controlRepository->find($controlId);
        $user = $userRepository->find($userId);
        $equipment = $equipmentRepository->find($equipmentId);

        return $this->render('/control/grue_auxiliaire/periodicControl.html.twig', [
            'controller_name' => 'GrueAuxiliaireController',
            'equipment'=>$equipment,
            'control'=>$control,
            'user'=>$user,
        ]);
    }
}
