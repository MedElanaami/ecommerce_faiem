<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $courteDesc;

    #[ORM\Column(type: 'string', length: 255)]
    private $longueDesc;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prixAchat;

    #[ORM\Column(type: 'float')]
    private $prixVente;

    #[ORM\Column(type: 'integer')]
    private $qteStock;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'boolean')]
    private $visibilite;

    #[ORM\Column(type: 'boolean')]
    private $favoris;

    #[ORM\Column(type: 'boolean')]
    private $reductionApplique;

    #[ORM\Column(type: 'float', nullable: true)]
    private $valeurReduction;

    #[ORM\ManyToOne(targetEntity: TypeReduction::class, inversedBy: 'produits')]
    private $typeReduction;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Image::class, orphanRemoval: true)]
    private $images;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'produits')]
    private $categories;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Variante::class, orphanRemoval: true)]
    private $variantes;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class, orphanRemoval: true)]
    private $ligneCommandes;

    public function __construct()
    {
        $this->visibilite = false;
        $this->favoris = true;
        $this->reductionApplique = false;
        $this->images = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->variantes = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();

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

    public function getCourteDesc(): ?string
    {
        return $this->courteDesc;
    }

    public function setCourteDesc(string $courteDesc): self
    {
        $this->courteDesc = $courteDesc;

        return $this;
    }

    public function getLongueDesc(): ?string
    {
        return $this->longueDesc;
    }

    public function setLongueDesc(string $longueDesc): self
    {
        $this->longueDesc = $longueDesc;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(float $prixAchat): self
    {
        $this->prixAchat = $prixAchat;

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

    public function getQteStock(): ?int
    {
        return $this->qteStock;
    }

    public function setQteStock(int $qteStock): self
    {
        $this->qteStock = $qteStock;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isVisibilite(): ?bool
    {
        return $this->visibilite;
    }

    public function setVisibilite(bool $visibilite): self
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    public function isFavoris(): ?bool
    {
        return $this->favoris;
    }

    public function setFavoris(bool $favoris): self
    {
        $this->favoris = $favoris;

        return $this;
    }

    public function isReductionApplique(): ?bool
    {
        return $this->reductionApplique;
    }

    public function setReductionApplique(bool $reductionApplique): self
    {
        $this->reductionApplique = $reductionApplique;

        return $this;
    }

    public function getValeurReduction(): ?float
    {
        return $this->valeurReduction;
    }

    public function setValeurReduction(float $valeurReduction): self
    {
        $this->valeurReduction = $valeurReduction;

        return $this;
    }

    public function getTypeReduction(): ?TypeReduction
    {
        return $this->typeReduction;
    }

    public function setTypeReduction(?TypeReduction $typeReduction): self
    {
        $this->typeReduction = $typeReduction;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduit($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduit() === $this) {
                $image->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

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
            $variante->setProduit($this);
        }

        return $this;
    }

    public function removeVariante(Variante $variante): self
    {
        if ($this->variantes->removeElement($variante)) {
            // set the owning side to null (unless already changed)
            if ($variante->getProduit() === $this) {
                $variante->setProduit(null);
            }
        }

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
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function prixReduction()
    {
        if ($this->getTypeReduction()) {
            if ($this->getTypeReduction()->getNom() == 'Prix')
                $prixReduction = $this->getPrixVente() - $this->getValeurReduction();
            else
                $prixReduction = $this->getPrixVente() * (1 - $this->getValeurReduction() / 100);
            return $prixReduction;
        }
        else
            return $this->getPrixVente();
    }

    public function valReduction()
    {
        if ($this->getTypeReduction()->getNom() == 'Prix')
            $valReduction = $this->getValeurReduction() . " DH";
        else
            $valReduction = $this->getValeurReduction() . "%";
        return $valReduction;
    }

}
