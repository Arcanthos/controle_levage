<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientCompanyRepository")
 */
class ClientCompany
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
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="date")
     */
    private $entryDate;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $codeAPE_NAF;

    /**
     * @ORM\Column(type="string", length=13)
     */
    private $numberVAT;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $siret;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="clientCompany", orphanRemoval=true)
     */
    private $contacts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ControlCompany", inversedBy="customers")
     */
    private $controlCompany;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="clientCompany", orphanRemoval=true)
     */
    private $equipments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quote", mappedBy="clientCompany")
     */
    private $devis;


    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->equipments = new ArrayCollection();
    }

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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(\DateTimeInterface $entryDate): self
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    public function getCodeAPENAF(): ?string
    {
        return $this->codeAPE_NAF;
    }

    public function setCodeAPENAF(?string $codeAPE_NAF): self
    {
        $this->codeAPE_NAF = $codeAPE_NAF;

        return $this;
    }

    public function getNumberVAT(): ?string
    {
        return $this->numberVAT;
    }

    public function setNumberVAT(string $numberVAT): self
    {
        $this->numberVAT = $numberVAT;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getControlCompany()
    {
        return $this->controlCompany;
    }

    /**
     * @param mixed $controlCompany
     */
    public function setControlCompany($controlCompany): void
    {
        $this->controlCompany = $controlCompany;
    }


    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setClientCompany($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getClientCompany() === $this) {
                $contact->setClientCompany(null);
            }
        }

        return $this;
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
            $equipment->setClientCompany($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->contains($equipment)) {
            $this->equipments->removeElement($equipment);
            // set the owning side to null (unless already changed)
            if ($equipment->getClientCompany() === $this) {
                $equipment->setClientCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quote[]
     */
    public function getDevis() : Collection
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



}
