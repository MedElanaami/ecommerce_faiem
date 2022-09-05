<?php

namespace App\Entity;

use App\Repository\VarianteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: VarianteRepository::class)]
class Variante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $qteStock;

    #[ORM\Column(type: 'float')]
    private $prixVente;

    #[ORM\ManyToOne(targetEntity: Attribut::class, inversedBy: 'variantes')]
    #[ORM\JoinColumn(nullable: false)]
    private $attribut;
    #[Ignore]
    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'variantes')]
    #[ORM\JoinColumn(nullable: false)]
    private $produit;

    #[ORM\OneToMany(mappedBy: 'variante', targetEntity: LigneCommande::class)]
    private $ligneCommandes;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteStock(): ?int
    {
        return $this->qteStock;
    }

    public function setQteStock(?int $qteStock): self
    {
        $this->qteStock = $qteStock;

        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prixVente;
    }

    public function setPrixVente(float $prixVente): self
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getAttribut(): ?Attribut
    {
        return $this->attribut;
    }

    public function setAttribut(?Attribut $attribut): self
    {
        $this->attribut = $attribut;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setVariante($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getVariante() === $this) {
                $ligneCommande->setVariante(null);
            }
        }

        return $this;
    }
}
