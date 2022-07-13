<?php

namespace App\Entity;

use App\Repository\TypeReductionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeReductionRepository::class)]
class TypeReduction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'typeReduction', targetEntity: Coupon::class, orphanRemoval: true)]
    private $coupons;

    public function __construct()
    {
        $this->coupons = new ArrayCollection();
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
     * @return Collection<int, Coupon>
     */
    public function getCoupons(): Collection
    {
        return $this->coupons;
    }

    public function addCoupon(Coupon $coupon): self
    {
        if (!$this->coupons->contains($coupon)) {
            $this->coupons[] = $coupon;
            $coupon->setTypeReduction($this);
        }

        return $this;
    }

    public function removeCoupon(Coupon $coupon): self
    {
        if ($this->coupons->removeElement($coupon)) {
            // set the owning side to null (unless already changed)
            if ($coupon->getTypeReduction() === $this) {
                $coupon->setTypeReduction(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
       return $this->nom;
    }


}
