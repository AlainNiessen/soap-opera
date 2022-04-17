<?php

namespace App\Entity;

use App\Repository\HuileEssentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HuileEssentielRepository::class)
 */
class HuileEssentiel
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
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="huileEssentiell")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=TraductionHuileEssentiel::class, mappedBy="huileEssentiel")
     */
    private $traductionHuileEssentiels;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->traductionHuileEssentiels = new ArrayCollection();
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
            $article->addHuileEssentiell($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removeHuileEssentiell($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionHuileEssentiel>
     */
    public function getTraductionHuileEssentiels(): Collection
    {
        return $this->traductionHuileEssentiels;
    }

    public function addTraductionHuileEssentiel(TraductionHuileEssentiel $traductionHuileEssentiel): self
    {
        if (!$this->traductionHuileEssentiels->contains($traductionHuileEssentiel)) {
            $this->traductionHuileEssentiels[] = $traductionHuileEssentiel;
            $traductionHuileEssentiel->setHuileEssentiel($this);
        }

        return $this;
    }

    public function removeTraductionHuileEssentiel(TraductionHuileEssentiel $traductionHuileEssentiel): self
    {
        if ($this->traductionHuileEssentiels->removeElement($traductionHuileEssentiel)) {
            // set the owning side to null (unless already changed)
            if ($traductionHuileEssentiel->getHuileEssentiel() === $this) {
                $traductionHuileEssentiel->setHuileEssentiel(null);
            }
        }

        return $this;
    }
}
