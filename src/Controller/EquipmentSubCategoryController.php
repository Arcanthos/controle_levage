<?php

namespace App\Controller;

use App\Entity\EquipmentSubCategory;
use App\Form\EquipmentSubCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipmentSubCategoryController extends AbstractController
{
    /**
     * @Route("/admin/create-equipment-subcategory", name="createEquipementSubCategory")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function createSubCategory(Request $request, EntityManagerInterface $entityManager)
    {
        $equipmentsubCategory = new EquipmentSubCategory();
        $equipmentsubCategoryForm = $this->createForm(EquipmentSubCategoryType::class, $equipmentsubCategory);

        $equipmentsubCategoryForm->handleRequest($request);
        if ($equipmentsubCategoryForm->isSubmitted() && $equipmentsubCategoryForm->isValid()){
            $entityManager->persist($equipmentsubCategory);
            $entityManager->flush();
        }

        return $this->render('equipement_sub_category/createSubCategory.html.twig', [
            'controller_name' => 'EquipmentSubCategoryController',
            'equipmentsubCategoryForm'=>$equipmentsubCategoryForm->createView()
        ]);
    }
}
