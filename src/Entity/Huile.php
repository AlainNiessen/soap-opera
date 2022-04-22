<?php

namespace App\Entity;

use App\Repository\HuileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HuileRepository::class)
 */
class Huile
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
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="huile")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=TraductionHuile::class, mappedBy="huile")
     */
    private $traductionHuiles;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->traductionHuiles = new ArrayCollection();
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
            $article->addHuile($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removeHuile($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionHuile>
     */
    public function getTraductionHuiles(): Collection
    {
        return $this->traductionHuiles;
    }

    public function addTraductionHuile(TraductionHuile $traductionHuile): self
    {
        if (!$this->traductionHuiles->contains($traductionHuile)) {
            $this->traductionHuiles[] = $traductionHuile;
            $traductionHuile->setHuile($this);
        }

        return $this;
    }

    public function removeTraductionHuile(TraductionHuile $traductionHuile): self
    {
        if ($this->traductionHuiles->removeElement($traductionHuile)) {
            // set the owning side to null (unless already changed)
            if ($traductionHuile->getHuile() === $this) {
                $traductionHuile->setHuile(null);
            }
        }

        return $this;
    }

    
}
