<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuoteRepository")
 */
class Quote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $pdfPath;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpen;

    /**
     * @ORM\Column(type="string")
     */
    private $controlType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment", inversedBy="devis")
     */
    private $equipment;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getPdfPath()
    {
        return $this->pdfPath;
    }

    /**
    * @param mixed $pdfPath
    */
    public function setPdfPath($pdfPath): void
    {
    $this->pdfPath = $pdfPath;
    }

    /**
     * @return mixed
     */
    public function getIsOpen()
    {
        return $this->isOpen;
    }

    /**
     * @param mixed $isOpen
     */
    public function setIsOpen($isOpen): void
    {
        $this->isOpen = $isOpen;
    }

    /**
     * @return mixed
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @param mixed $equipment
     */
    public function setEquipment($equipment): void
    {
        $this->equipment = $equipment;
    }

    /**
     * @return mixed
     */
    public function getControlType()
    {
        return $this->controlType;
    }

    /**
     * @param mixed $controlType
     */
    public function setControlType($controlType): void
    {
        $this->controlType = $controlType;
    }




}
