<?php

namespace App\Controller;

use App\Entity\EquipmentSubCategory;
use App\Form\EquipmentSubCategoryType;
use App\Repository\EquipmentCategoryRepository;
use App\Repository\EquipmentSubCategoryRepository;
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
     * @param EquipmentSubCategoryRepository $subCategoryRepository
     * @param EquipmentCategoryRepository $categoryRepository
     * @return Response
     */
    public function createSubCategory(Request $request, EntityManagerInterface $entityManager, EquipmentSubCategoryRepository $subCategoryRepository, EquipmentCategoryRepository $categoryRepository)
    {
        $equipmentsubCategory = new EquipmentSubCategory();
        $equipmentsubCategoryForm = $this->createForm(EquipmentSubCategoryType::class, $equipmentsubCategory);

        $equipmentsubCategoryForm->handleRequest($request);
        if ($equipmentsubCategoryForm->isSubmitted() && $equipmentsubCategoryForm->isValid()){
            $entityManager->persist($equipmentsubCategory);
            $entityManager->flush();
        }
        $allParentCategory = $categoryRepository->findAll();
        $allSubcategory = $subCategoryRepository->findAll();

        return $this->render('equipement_sub_category/createSubCategory.html.twig', [
            'controller_name' => 'EquipmentSubCategoryController',
            'equipmentsubCategoryForm'=>$equipmentsubCategoryForm->createView(),
            'allSubCategory'=>$allSubcategory,
            'allParentCategory'=>$allParentCategory
        ]);
    }
}
