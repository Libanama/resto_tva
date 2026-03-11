<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $ttc55 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $ttc10 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $ttc20 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $pourboire = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTtc55(): ?string
    {
        return $this->ttc55;
    }

    public function setTtc55(?string $ttc55): static
    {
        $this->ttc55 = $ttc55;

        return $this;
    }

    public function getTtc10(): ?string
    {
        return $this->ttc10;
    }

    public function setTtc10(?string $ttc10): static
    {
        $this->ttc10 = $ttc10;

        return $this;
    }

    public function getTtc20(): ?string
    {
        return $this->ttc20;
    }

    public function setTtc20(?string $ttc20): static
    {
        $this->ttc20 = $ttc20;

        return $this;
    }

    public function getPourboire(): ?string
    {
        return $this->pourboire;
    }

    public function setPourboire(?string $pourboire): static
    {
        $this->pourboire = $pourboire;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
