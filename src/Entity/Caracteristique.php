<?php

namespace App\Entity;

use App\Repository\CaracteristiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaracteristiqueRepository::class)]
class Caracteristique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'caracteristique', targetEntity: Attribut::class, orphanRemoval: true)]
    private $attributs;

    public function __construct()
    {
        $this->attributs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Attribut>
     */
    public function getAttributs(): Collection
    {
        return $this->attributs;
    }

    public function addAttribut(Attribut $attribut): self
    {
        if (!$this->attributs->contains($attribut)) {
            $this->attributs[] = $attribut;
            $attribut->setCaracteristique($this);
        }

        return $this;
    }

    public function removeAttribut(Attribut $attribut): self
    {
        if ($this->attributs->removeElement($attribut)) {
            // set the owning side to null (unless already changed)
            if ($attribut->getCaracteristique() === $this) {
                $attribut->setCaracteristique(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
      return $this->getNom();
    }

}
