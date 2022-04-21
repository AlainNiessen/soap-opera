<?php

namespace App\Entity;

use App\Repository\PartenaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartenaireRepository::class)
 */
class Partenaire
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
     * @ORM\ManyToMany(targetEntity=Categorie::class, inversedBy="partenaires")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="partenaire")
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=TraductionPartenaire::class, mappedBy="partenaire")
     */
    private $traductionPartenaires;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="partenaire")
     */
    private $images;

    // function for display in admin interface
    public function __toString(): string
    {
        return $this->nom;
    }

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
        $this->traductionPartenaires = new ArrayCollection();
        $this->images = new ArrayCollection();
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
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        $this->categorie->removeElement($categorie);

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
     * @return Collection<int, TraductionPartenaire>
     */
    public function getTraductionPartenaires(): Collection
    {
        return $this->traductionPartenaires;
    }

    public function addTraductionPartenaire(TraductionPartenaire $traductionPartenaire): self
    {
        if (!$this->traductionPartenaires->contains($traductionPartenaire)) {
            $this->traductionPartenaires[] = $traductionPartenaire;
            $traductionPartenaire->setPartenaire($this);
        }

        return $this;
    }

    public function removeTraductionPartenaire(TraductionPartenaire $traductionPartenaire): self
    {
        if ($this->traductionPartenaires->removeElement($traductionPartenaire)) {
            // set the owning side to null (unless already changed)
            if ($traductionPartenaire->getPartenaire() === $this) {
                $traductionPartenaire->setPartenaire(null);
            }
        }

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
            $image->setPartenaire($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPartenaire() === $this) {
                $image->setPartenaire(null);
            }
        }

        return $this;
    }
}
