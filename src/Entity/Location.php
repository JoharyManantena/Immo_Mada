<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDebut = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $client = null;

    #[ORM\ManyToOne(targetEntity: Bien::class)]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id", nullable: false)]
    private ?Bien $bien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeImmutable $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getClient(): ?Utilisateur
    {
        return $this->client;
    }

    public function setClient(?Utilisateur $client): static
    {
        $this->client = $client;

        return $this;
    }
    public function getBien(): ?Bien
    {
        return $this->bien;
    }

    public function getChiffreAffaires(): float
    {
        $loyer = $this->bien?->getLoyer() ?? 0;
        return $loyer * $this->duree;
    }

    
    public function getGains(): float
    {
        $commission = $this->bien?->getType()?->getCommission() ?? 0;
        return $this->getChiffreAffaires() * ($commission / 100);
    }

    public function getMontantTotal(): float
    {
        $loyer = $this->bien?->getLoyer() ?? 0;
        return $loyer * $this->duree;
    }

}
