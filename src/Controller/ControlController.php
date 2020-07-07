<?php

namespace App\Controller;

use App\Entity\Control;
use App\Form\ControlType;
use App\Repository\ClientCompanyRepository;
use App\Repository\ControlRepository;
use App\Repository\EquipmentRepository;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControlController extends AbstractController
{
    /**
     * @Route("/create-control/{devisId}", name="create_control", )
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $devisId
     * @param QuoteRepository $devisRepository
     * @param EquipmentRepository $equipmentRepository
     * @return RedirectResponse|Response
     */
    public function createControl(Request $request, EntityManagerInterface $em, $devisId, QuoteRepository $devisRepository, EquipmentRepository $equipmentRepository)
    {
        //Récupération des informations concernant l'équipement contrôlé
        $devis = $devisRepository->find($devisId);
        $equipmentControlList = unserialize($devis->getSerializedContent());

        $user = $this->getUser();
        $genericControl = new Control();
        $controlForm = $this->createForm(ControlType::class, $genericControl);


        $controlForm->handleRequest($request);
        if ($controlForm->isSubmitted() && $controlForm->isValid()) {
            foreach ($equipmentControlList as $equipmentID => $controlType) {
                if ($controlType != 'null') {
                    $control = clone $genericControl;
                    $equipment = $equipmentRepository->find($equipmentID);
                    $control->setControlEquipment($equipment);
                    $control->setType($controlType);


                    //ainsi que la date du prochain contrôle dans 6 Mois
                    if ($control->getControlEquipment()->getSubcategory()->getPeriodicity() == 6) {
                        $interval = new \DateInterval('P6M');
                        $dateNextControl = $control->getDate()->add($interval);
                        $control->setDateNextControl($dateNextControl);
                    } //ou la date du prochain contrôle dans 3 Mois
                    elseif ($control->getControlEquipment()->getSubcategory()->getPeriodicity() == 3) {
                        $interval = new \DateInterval('P3M');
                        $dateNextControl = $control->getDate()->add($interval);
                        $control->setDateNextControl($dateNextControl);
                    } //sinon la date du prochain contrôle dans 12 Mois
                    else {
                        $interval = new \DateInterval('P12M');
                        $dateNextControl = $control->getDate()->add($interval);
                        $control->setDateNextControl($dateNextControl);
                    }


                    //persistance du nouveau contrôle
                    $em->persist($control);
                    $em->flush();
                }
            }
            $devis->setIsOpen(false);
            return $this->redirectToRoute('homePanel');
        }

        return $this->render('control/createControl.html.twig', [
            'controller_name' => 'ControlController',
            'controlForm' => $controlForm->createView(),
            'user' => $user,
            'clientCompany' => $devis->getClientCompany()
        ]);
    }

    /**
     * @Route("/start-control", name="startControl")
     * @param ControlRepository $controlRepository
     * @return Response
     */
    public function startControl(ControlRepository $controlRepository)
    {
        $controlsToDo = $controlRepository->controlIsNotDone();
        return $this->render('control/startControl.html.twig', [
            'controlsToDo' => $controlsToDo
        ]);
    }


    /**
     * @Route("/add-control", name="addControl")
     * @param Request $request
     * @param EquipmentRepository $equipmentRepository
     * @param ClientCompanyRepository $clientCompanyRepository
     * @return Response
     */
    public function addControl(Request $request, EquipmentRepository $equipmentRepository, ClientCompanyRepository $clientCompanyRepository)
    {
        $controlCompany = $this->getUser()->getCompany();
        $controlCompanyId = $controlCompany->getId();
        $allEquipments = $equipmentRepository->findAllEquipmentByCompanyControlCompany($controlCompanyId);
        $allClientCompany = $clientCompanyRepository->findAll();
        $equipmentToControl = [];


        foreach ($allEquipments as $equipment) {
            $todayLessOneMonth = (new \DateTime())->modify('-1 month')->getTimestamp();
            $controls = $equipment->getControls();
            $equipmentLastDevis = $equipment->getClosedDevis();
            $equipmentDevis = $equipment->getDevis();


            $equipmentLastControl = null;
            $equipmentNextControlDate = null;
            if (!$controls->isEmpty()) {
                $equipmentLastControl = $controls->last();
                $equipmentNextControlDate = ($equipmentLastControl->getDateNextControl())->getTimestamp();
            }

            if ((empty($equipmentLastDevis) && $equipmentDevis == null) || ($equipmentDevis == null && ($equipmentNextControlDate < $todayLessOneMonth))) {
                array_push($equipmentToControl, $equipment);
            }


        }
        //recupération des données du formulaire
        if ($request->getMethod() == Request::METHOD_POST) {
            $data = $request->request->all();
            $data = serialize($data);
            return $this->redirectToRoute('newDevis', ['equipmentControlList' => $data]);
        }


        return $this->render('control/addControl.html.twig', [
            "equipmentToControl" => $equipmentToControl,
            "clientCompanys" => $allClientCompany
        ]);
    }

    /**
     * @Route("/access-controlForm/{id}", name="accessControl")
     * @param $id
     * @param ControlRepository $controlRepository
     * @return RedirectResponse
     */
    public function accessControl($id, ControlRepository $controlRepository)
    {
        $control = $controlRepository->find($id);
        $equipment = $control->getControlEquipment();
        dump($equipment);
        return $this->redirectToRoute(($equipment->getEquipmentCategory()->getAlias()) . ($control->getType() . "Control"), [
            'id' => $id,
            'control' => $control,
            'controlId' => strval($control->getId()),
            'equipment' => $equipment,
            'equipmentCategory' => $equipment->getEquipmentCategory()
        ]);
    }

}
