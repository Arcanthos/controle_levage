<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Control::class, mappedBy="controlEquipment")
     */
    private $controls;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipmentSubCategory", inversedBy="equipments")
     */
    private $subcategory;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quote", inversedBy="equipments")
     */
    private $devis;


    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $closedDevis;


    public function __construct()
    {
        $this->controls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Control[]
     */
    public function getControls(): Collection
    {
        return $this->controls;
    }

    public function addControl(Control $control): self
    {
        if (!$this->controls->contains($control)) {
            $this->controls[] = $control;
            $control->setControlEquipment($this);
        }

        return $this;
    }

    public function removeControl(Control $control): self
    {
        if ($this->controls->contains($control)) {
            $this->controls->removeElement($control);
            // set the owning side to null (unless already changed)
            if ($control->getControlEquipment() === $this) {
                $control->setControlEquipment(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * @param mixed $subcategory
     */
    public function setSubcategory($subcategory): void
    {
        $this->subcategory = $subcategory;
    }

    /**
     * @return mixed
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * @param mixed $devis
     */
    public function setDevis($devis): void
    {
        $this->devis = $devis;
    }

    /**
     * @return Collection|Quote[]
     */
    public function getClosedDevis()
    {
        return $this->closedDevis;
    }

    /**
     * @param mixed $closedDevis
     */
    public function setClosedDevis($closedDevis): void
    {
        $this->closedDevis = $closedDevis;
    }




}
