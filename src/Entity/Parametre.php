<?php

namespace App\Entity;

use App\Repository\ParametreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ParametreRepository::class)]
#[Vich\Uploadable]
class Parametre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomSite;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $tel;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $facebook;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $instagram;

    #[ORM\Column(type: 'string', length: 255)]
    private $whatsapp;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adresse;

    #[ORM\Column(type: 'float', nullable: true)]
    private $seuilLivraison;

    #[ORM\Column(type: 'boolean')]
    private $gestionStock;

    #[Vich\UploadableField(mapping: 'parametre', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string')]
    private ?string $imageName = null;

    #[ORM\Column(type: 'integer')]
    private ?int $imageSize = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idPaypal = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSite(): ?string
    {
        return $this->nomSite;
    }

    public function setNomSite(string $nomSite): self
    {
        $this->nomSite = $nomSite;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getWhatsapp(): ?string
    {
        return $this->whatsapp;
    }

    public function setWhatsapp(string $whatsapp): self
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSeuilLivraison(): ?float
    {
        return $this->seuilLivraison;
    }

    public function setSeuilLivraison(?float $seuilLivraison): self
    {
        $this->seuilLivraison = $seuilLivraison;

        return $this;
    }

    public function isGestionStock(): ?bool
    {
        return $this->gestionStock;
    }

    public function setGestionStock(bool $gestionStock): self
    {
        $this->gestionStock = $gestionStock;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getIdPaypal(): ?string
    {
        return $this->idPaypal;
    }

    public function setIdPaypal(?string $idPaypal): self
    {
        $this->idPaypal = $idPaypal;

        return $this;
    }
}
