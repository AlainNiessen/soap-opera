<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private $dateAffichageStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAffichageEnd;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Pourcentage;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="promotions")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="promotions")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=TraductionPromotion::class, mappedBy="promotion")
     */
    private $traductionPromotions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBackend;

    // function for display in admin interface
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

    public function getDateAffichageStart(): ?\DateTimeInterface
    {
        return $this->dateAffichageStart;
    }

    public function setDateAffichageStart(\DateTimeInterface $dateAffichageStart): self
    {
        $this->dateAffichageStart = $dateAffichageStart;

        return $this;
    }

    public function getDateAffichageEnd(): ?\DateTimeInterface
    {
        return $this->dateAffichageEnd;
    }

    public function setDateAffichageEnd(\DateTimeInterface $dateAffichageEnd): self
    {
        $this->dateAffichageEnd = $dateAffichageEnd;

        return $this;
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

    public function getPourcentage(): ?int
    {
        return $this->Pourcentage;
    }

    public function setPourcentage(?int $Pourcentage): self
    {
        $this->Pourcentage = $Pourcentage;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

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
