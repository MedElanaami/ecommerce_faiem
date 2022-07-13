<?php

namespace App\Entity;

use App\Repository\AttributRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributRepository::class)]
class Attribut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $valeur;

    #[ORM\ManyToOne(targetEntity: Caracteristique::class, inversedBy: 'attributs')]
    #[ORM\JoinColumn(nullable: false)]
    private $caracteristique;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getCaracteristique(): ?Caracteristique
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(?Caracteristique $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }



}
