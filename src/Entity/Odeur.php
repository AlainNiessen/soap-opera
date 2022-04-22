<?php

namespace App\Entity;

use App\Repository\OdeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OdeurRepository::class)
 */
class Odeur
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
    private $nomBackend;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="odeur")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=TraductionOdeur::class, mappedBy="odeur")
     */
    private $traductionOdeurs;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->traductionOdeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBackend(): ?string
    {
        return $this->nomBackend;
    }

    public function setNomBackend(string $nomBackend): self
    {
        $this->nomBackend = $nomBackend;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setOdeur($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getOdeur() === $this) {
                $article->setOdeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionOdeur>
     */
    public function getTraductionOdeurs(): Collection
    {
        return $this->traductionOdeurs;
    }

    public function addTraductionOdeur(TraductionOdeur $traductionOdeur): self
    {
        if (!$this->traductionOdeurs->contains($traductionOdeur)) {
            $this->traductionOdeurs[] = $traductionOdeur;
            $traductionOdeur->setOdeur($this);
        }

        return $this;
    }

    public function removeTraductionOdeur(TraductionOdeur $traductionOdeur): self
    {
        if ($this->traductionOdeurs->removeElement($traductionOdeur)) {
            // set the owning side to null (unless already changed)
            if ($traductionOdeur->getOdeur() === $this) {
                $traductionOdeur->setOdeur(null);
            }
        }

        return $this;
    }

    
}
