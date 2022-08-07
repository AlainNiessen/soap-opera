<?php

namespace App\Entity;

use App\Repository\PointDeVenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointDeVenteRepository::class)
 */
class PointDeVente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="pointDeVentes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="pointDeVente")
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=TraductionPointDeVente::class, mappedBy="pointDeVente")
     */
    private $traductionPointDeVentes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $longitude;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nom;
    }

    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->traductionPointDeVentes = new ArrayCollection();
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

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setPointDeVente($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPointDeVente() === $this) {
                $image->setPointDeVente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionPointDeVente>
     */
    public function getTraductionPointDeVentes(): Collection
    {
        return $this->traductionPointDeVentes;
    }

    public function addTraductionPointDeVente(TraductionPointDeVente $traductionPointDeVente): self
    {
        if (!$this->traductionPointDeVentes->contains($traductionPointDeVente)) {
            $this->traductionPointDeVentes[] = $traductionPointDeVente;
            $traductionPointDeVente->setPointDeVente($this);
        }

        return $this;
    }

    public function removeTraductionPointDeVente(TraductionPointDeVente $traductionPointDeVente): self
    {
        if ($this->traductionPointDeVentes->removeElement($traductionPointDeVente)) {
            // set the owning side to null (unless already changed)
            if ($traductionPointDeVente->getPointDeVente() === $this) {
                $traductionPointDeVente->setPointDeVente(null);
            }
        }

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
