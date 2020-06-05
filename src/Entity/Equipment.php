<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentRepository")
 */
class Equipment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $serialNumber;

    /**
     * @ORM\ManyToOne(targetEntity=EquipmentCategory::class, inversedBy="equipments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipmentCategory;

    /**
     * @ORM\ManyToOne(targetEntity=ClientCompany::class, inversedBy="equipments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientCompany;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getEquipmentCategory(): ?EquipmentCategory
    {
        return $this->equipmentCategory;
    }

    public function setEquipmentCategory(?EquipmentCategory $equipmentCategory): self
    {
        $this->equipmentCategory = $equipmentCategory;

        return $this;
    }

    public function getClientCompany(): ?ClientCompany
    {
        return $this->clientCompany;
    }

    public function setClientCompany(?ClientCompany $clientCompany): self
    {
        $this->clientCompany = $clientCompany;

        return $this;
    }
}
