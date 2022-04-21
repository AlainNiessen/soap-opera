<?php

namespace App\Entity;

use App\Repository\BeurreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BeurreRepository::class)
 */
class Beurre
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
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="beurre")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=TraductionBeurre::class, mappedBy="beurre")
     */
    private $traductionBeurres;

    // function for display in admin interface
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->traductionBeurres = new ArrayCollection();
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
            $article->addBeurre($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removeBeurre($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionBeurre>
     */
    public function getTraductionBeurres(): Collection
    {
        return $this->traductionBeurres;
    }

    public function addTraductionBeurre(TraductionBeurre $traductionBeurre): self
    {
        if (!$this->traductionBeurres->contains($traductionBeurre)) {
            $this->traductionBeurres[] = $traductionBeurre;
            $traductionBeurre->setBeurre($this);
        }

        return $this;
    }

    public function removeTraductionBeurre(TraductionBeurre $traductionBeurre): self
    {
        if ($this->traductionBeurres->removeElement($traductionBeurre)) {
            // set the owning side to null (unless already changed)
            if ($traductionBeurre->getBeurre() === $this) {
                $traductionBeurre->setBeurre(null);
            }
        }

        return $this;
    }
}
