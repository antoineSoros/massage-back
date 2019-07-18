<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrestationRepository")
 */
class Prestation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Massage", cascade={"persist", "remove"})
     */
    private $massage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $prestationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Invoice", inversedBy="prestation")
     */
    private $invoice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getMassage(): ?Massage
    {
        return $this->massage;
    }

    public function setMassage(?Massage $massage): self
    {
        $this->massage = $massage;

        return $this;
    }

    public function getPrestationDate(): ?\DateTimeInterface
    {
        return $this->prestationDate;
    }

    public function setPrestationDate(\DateTimeInterface $prestationDate): self
    {
        $this->prestationDate = $prestationDate;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function __toString()
    {
        $date = $this->getPrestationDate()->format("d/m/Y H:i");
        $client="" ;
        if($this->getClient()->getProfile()->getName()==="SALON"){ $client = $this->getClient()->getCompany()->getCompanyName()
        ." n° ".$this->getId();}
        else{
            $client = $this->getClient()->getFirstname()." ".$this->getClient()->getLastname()." n° ".$this->getId();
        }

     return "prestation du ".$date." pour ".$client;
    }

}
