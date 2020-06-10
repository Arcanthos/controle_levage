<?php

namespace App\Entity;

use App\Repository\EquipmentCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentCategoryRepository::class)
 */
class EquipmentCategory
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
    private $category;


    /**
     * @ORM\Column(type="boolean")
     */
    private $accessories;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasPeriodicControl;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasCommissioningControl;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasReturnToServiceControl;



    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="equipmentCategory", orphanRemoval=true)
     */
    private $equipments;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccessories()
    {
        return $this->accessories;
    }

    /**
     * @param mixed $accessories
     */
    public function setAccessories($accessories): void
    {
        $this->accessories = $accessories;
    }

    /**
     * @return mixed
     */
    public function getHasPeriodicControl()
    {
        return $this->hasPeriodicControl;
    }

    /**
     * @param mixed $hasPeriodicControl
     */
    public function setHasPeriodicControl($hasPeriodicControl): void
    {
        $this->hasPeriodicControl = $hasPeriodicControl;
    }

    /**
     * @return mixed
     */
    public function getHasCommissioningControl()
    {
        return $this->hasCommissioningControl;
    }

    /**
     * @param mixed $hasCommissioningControl
     */
    public function setHasCommissioningControl($hasCommissioningControl): void
    {
        $this->hasCommissioningControl = $hasCommissioningControl;
    }

    /**
     * @return mixed
     */
    public function getHasReturnToServiceControl()
    {
        return $this->hasReturnToServiceControl;
    }

    /**
     * @param mixed $hasReturnToServiceControl
     */
    public function setHasReturnToServiceControl($hasReturnToServiceControl): void
    {
        $this->hasReturnToServiceControl = $hasReturnToServiceControl;
    }


    /**
     * @return Collection|Equipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->setEquipmentCategory($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->contains($equipment)) {
            $this->equipments->removeElement($equipment);
            // set the owning side to null (unless already changed)
            if ($equipment->getEquipmentCategory() === $this) {
                $equipment->setEquipmentCategory(null);
            }
        }

        return $this;
    }
}
