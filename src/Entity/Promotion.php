<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="dateStart", message = "promotion.dateEnd.greaterThan")
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="float", scale=2, nullable=false)
     */
    private $Pourcentage;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="article")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=Categorie::class, mappedBy="categorie")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=TraductionPromotion::class, mappedBy="promotion")
     */
    private $traductionPromotions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBackend;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    public function __construct()
    {
        $this->traductionPromotions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getPourcentage(): ?float
    {
        return $this->Pourcentage;
    }

    public function setPourcentage(?float $Pourcentage): self
    {
        $this->Pourcentage = $Pourcentage;

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
            $article->setPromotion($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getPromotion() === $this) {
                $article->setPromotion(null);
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

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categories->contains($categorie)) {
            $this->categories[] = $categorie;
            $categorie->setPromotion($this);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->categories->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getPromotion() === $this) {
                $categorie->setPromotion(null);
            }
        }

        return $this;
    }
    
    /**
     * @return Collection<int, TraductionPromotion>
     */
    public function getTraductionPromotions(): Collection
    {
        return $this->traductionPromotions;
    }

    public function addTraductionPromotion(TraductionPromotion $traductionPromotion): self
    {
        if (!$this->traductionPromotions->contains($traductionPromotion)) {
            $this->traductionPromotions[] = $traductionPromotion;
            $traductionPromotion->setPromotion($this);
        }

        return $this;
    }

    public function removeTraductionPromotion(TraductionPromotion $traductionPromotion): self
    {
        if ($this->traductionPromotions->removeElement($traductionPromotion)) {
            // set the owning side to null (unless already changed)
            if ($traductionPromotion->getPromotion() === $this) {
                $traductionPromotion->setPromotion(null);
            }
        }

        return $this;
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
}
