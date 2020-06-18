<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevisController extends AbstractController
{
    /**
     * @Route("/new-devis/{equipmentID}", name="newDevis")
     * @param $equipmentID
     * @param EquipmentRepository $equipmentRepository
     * @param EntityManager $entityManager
     * @return Response
     */
    public function newDevis($equipmentID, EquipmentRepository $equipmentRepository, EntityManager $entityManager)
    {
        $equipmentToControl = $equipmentRepository->find($equipmentID);
        $newDevis = new Quote();
        $clientCompany = $equipmentToControl->getClientCompany();
        $controlCompany = $clientCompany->getControlCompany();

        //sauvegarde du devis créé en DB
        $newDevis->setDate(new \DateTime('now'));
        try {
            $entityManager->persist($newDevis);
            $entityManager->flush();
        } catch (ORMException $e) {
            echo("ERREUR, le devis n'a pas pu être enregistré");
        }



        return $this->render('devis/new.html.twig', [
            'controller_name' => 'DevisController',
            'clientCompany'=>$clientCompany,
            'controlCompany'=>$controlCompany,
            'devis'=>$newDevis,
            'EquipmentToControl'=>$equipmentToControl
        ]);
    }
}
