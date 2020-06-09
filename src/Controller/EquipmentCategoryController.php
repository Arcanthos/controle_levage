<?php

namespace App\Controller;

use App\Entity\EquipmentCategory;
use App\Form\EquipmentCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipmentCategoryController extends AbstractController
{
    /**
     * @Route("/createEquipmentCategory", name="createEquipmentCategory")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function createEquipmentCategory(Request $request, EntityManagerInterface $em)
    {
        //initialisation du formulaire de création d'une nouvelle catégorie d'équipement
        $equipmentCategory = new EquipmentCategory();
        $equipmentCategoryForm = $this->createForm(EquipmentCategoryType::class, $equipmentCategory);

        //persistance de la nouvelle catégorie
        $equipmentCategoryForm->handleRequest($request);
        if($equipmentCategoryForm->isSubmitted()&& $equipmentCategoryForm->isValid())
        {
            $em->persist($equipmentCategory);
            $em->flush();

            $this->addFlash('success', 'La catégorie a été ajoutée');
            //TODO : redirection vers l'ajout d'un nouvel équipement
            //return $this->redirectToRoute();
        }
        return $this->render('equipment_category/createEquipmentCategory.html.twig', [
            'equipmentCategoryForm'=> $equipmentCategoryForm->createView()
        ]);
    }
}
