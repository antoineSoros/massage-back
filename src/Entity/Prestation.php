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
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Massage", cascade={"persist", "remove"})
     */
    private $massage;

    public function getId(): ?string
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
}
