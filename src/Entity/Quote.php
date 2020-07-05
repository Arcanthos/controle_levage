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
     * Bidirectionnel
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipment", mappedBy="devis")
     */
    private $equipments;


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




}
