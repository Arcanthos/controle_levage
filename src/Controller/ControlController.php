<?php

namespace App\Controller;

use App\Entity\Control;
use App\Entity\Equipment;
use App\Form\ControlType;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControlController extends AbstractController
{
    /**
     * @Route("/create-control/{id}", name="create_control", requirements={"id": "\d+"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $id
     * @param EquipmentRepository $equipmentRepo
     * @return RedirectResponse|Response
     */
    public function createControl(Request $request, EntityManagerInterface $em, $id, EquipmentRepository $equipmentRepo)
    {
        //Récupération des informations concernant l'équipement contrôlé
        $equipmentRepo = $em->getRepository(Equipment::class);
        $equipment = $equipmentRepo->find($id);

        $user= $this->getUser();
        //initialisation du formulaire de création d'un nouveau contrôle
        $control = new Control();
        $controlForm = $this->createForm(ControlType::class, $control);

        //persistance du nouveau contrôle
        $controlForm->handleRequest($request);
        if($controlForm->isSubmitted() && $controlForm->isValid())
        {
            $control->setControlEquipment($equipment);
            $date = new \DateTime();
            $control->setDate(clone $date);
            /*$em->persist($control);
            $em->flush();

            $this->addFlash('success','Le nouveau contrôle a bien été enregistré');*/
            return $this->render('control/grueAuxiliaireControl.html.twig', [
                'equipment'=>$equipment,
                'control'=>$control,
                'user'=>$user,
            ]);
        }

        return $this->render('control/createControl.html.twig', [
            'controller_name' => 'ControlController',
            'controlForm'=> $controlForm->createView(),
            'equipment'=> $equipment,
            'control'=> $control,
            'user'=> $user,
        ]);
    }
}
