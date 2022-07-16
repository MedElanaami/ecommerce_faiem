<?php

namespace App\Entity;

use App\Repository\AttributRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'attribut', targetEntity: Variante::class, orphanRemoval: true)]
    private $variantes;

    public function __construct()
    {
        $this->variantes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Variante>
     */
    public function getVariantes(): Collection
    {
        return $this->variantes;
    }

    public function addVariante(Variante $variante): self
    {
        if (!$this->variantes->contains($variante)) {
            $this->variantes[] = $variante;
            $variante->setAttribut($this);
        }

        return $this;
    }

    public function removeVariante(Variante $variante): self
    {
        if ($this->variantes->removeElement($variante)) {
            // set the owning side to null (unless already changed)
            if ($variante->getAttribut() === $this) {
                $variante->setAttribut(null);
            }
        }

        return $this;
    }



}
