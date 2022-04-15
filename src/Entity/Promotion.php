<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
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
}
