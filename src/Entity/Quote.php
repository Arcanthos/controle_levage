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
     * il s'agit d'un tableau serialisé qui associe chaque élément du devis à son type de controle
     */
    private $serializedContent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment", mappedBy="openDevis")
     */
    private $equipments;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientCompany", inversedBy="devis")
     */
    private $clientCompany;


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

    /**
     * @return mixed
     */
    public function getClientCompany()
    {
        return $this->clientCompany;
    }

    /**
     * @param mixed $clientCompany
     */
    public function setClientCompany($clientCompany): void
    {
        $this->clientCompany = $clientCompany;
    }

    /**
     * @return mixed
     */
    public function getSerializedContent()
    {
        return $this->serializedContent;
    }

    /**
     * @param mixed $serializedContent
     */
    public function setSerializedContent($serializedContent): void
    {
        $this->serializedContent = $serializedContent;
    }





}
