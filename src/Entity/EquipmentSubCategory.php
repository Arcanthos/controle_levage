<?php

namespace App\Entity;

use App\Repository\EquipmentSubCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentSubCategoryRepository::class)
 */
class EquipmentSubCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $periodicity;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2, nullable=true)
     */
    private $PeriodicControlPrice;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2, nullable=true)
     */
    private $MESControlPrice;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2, nullable=true)
     */
    private $RMESControlPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipmentCategory", inversedBy="subCategorys")
     */
    private $parentCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment", mappedBy="subcategory", orphanRemoval=true)
     */
    private $equipments;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * @param mixed $parentCategory
     */
    public function setParentCategory($parentCategory): void
    {
        $this->parentCategory = $parentCategory;
    }

    /**
     * @return mixed
     */
    public function getEquipments()
    {
        return $this->equipments;
    }

    /**
     * @param mixed $equipments
     */
    public function setEquipments($equipments): void
    {
        $this->equipments = $equipments;
    }

    /**
     * @return mixed
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * @param mixed $periodicity
     */
    public function setPeriodicity($periodicity): void
    {
        $this->periodicity = $periodicity;
    }

    /**
     * @return mixed
     */
    public function getPeriodicControlPrice()
    {
        return $this->PeriodicControlPrice;
    }

    /**
     * @param mixed $PeriodicControlPrice
     */
    public function setPeriodicControlPrice($PeriodicControlPrice): void
    {
        $this->PeriodicControlPrice = $PeriodicControlPrice;
    }

    /**
     * @return mixed
     */
    public function getMESControlPrice()
    {
        return $this->MESControlPrice;
    }

    /**
     * @param mixed $MESControlPrice
     */
    public function setMESControlPrice($MESControlPrice): void
    {
        $this->MESControlPrice = $MESControlPrice;
    }

    /**
     * @return mixed
     */
    public function getRMESControlPrice()
    {
        return $this->RMESControlPrice;
    }

    /**
     * @param mixed $RMESControlPrice
     */
    public function setRMESControlPrice($RMESControlPrice): void
    {
        $this->RMESControlPrice = $RMESControlPrice;
    }



}
