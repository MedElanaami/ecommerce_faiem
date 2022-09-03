<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateCommande;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prixTotal;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prixLivraison;

    #[ORM\ManyToOne(targetEntity: Coupon::class, inversedBy: 'commandes')]
    private $coupon;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $couponApplique;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $vu;

    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: 'commandes')]
    private $status;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class, orphanRemoval: true)]
    private $ligneCommandes;

    #[ORM\Column]
    private ?int $typePaiement = null;

    #[ORM\Column]
    private ?bool $payee = null;

    public function __construct()
    {
        $this->vu = false;
        $this->prixLivraison = 0;
        $this->dateCommande = new \DateTimeImmutable();
        $this->ligneCommandes = new ArrayCollection();
        $this->payee=false;
    }

    /**
     * @return false
     */
    public function getVu(): bool
    {
        return $this->vu;
    }

    /**
     * @param false $vu
     */
    public function setVu(bool $vu): void
    {
        $this->vu = $vu;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(?float $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function isCouponApplique(): ?bool
    {
        return $this->couponApplique;
    }

    public function setCouponApplique(?bool $couponApplique): self
    {
        $this->couponApplique = $couponApplique;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
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
            $ligneCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommande() === $this) {
                $ligneCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrixLivraison()
    {
        return $this->prixLivraison;
    }

    /**
     * @param mixed $prixLivraison
     */
    public function setPrixLivraison($prixLivraison): void
    {
        $this->prixLivraison = $prixLivraison;
    }

    public function getTypePaiement(): ?int
    {
        return $this->typePaiement;
    }

    public function setTypePaiement(int $typePaiement): self
    {
        $this->typePaiement = $typePaiement;

        return $this;
    }

    public function isPayee(): ?bool
    {
        return $this->payee;
    }

    public function setPayee(bool $payee): self
    {
        $this->payee = $payee;

        return $this;
    }


}
