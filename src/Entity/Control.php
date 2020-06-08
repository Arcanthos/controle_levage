<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ControlRepository")
 */
class Control
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $result;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateNextControl;

    /**
     * @ORM\ManyToOne(targetEntity=Equipment::class, inversedBy="controls")
     */
    private $controlEquipment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getResult(): ?bool
    {
        return $this->result;
    }

    public function setResult(?bool $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getDateNextControl(): ?DateTimeInterface
    {
        return $this->dateNextControl;
    }

    public function setDateNextControl(DateTimeInterface $dateNextControl): self
    {
        $this->dateNextControl = $dateNextControl;

        return $this;
    }

    public function getControlEquipment(): ?Equipment
    {
        return $this->controlEquipment;
    }

    public function setControlEquipment(?Equipment $controlEquipment): self
    {
        $this->controlEquipment = $controlEquipment;

        return $this;
    }
}
