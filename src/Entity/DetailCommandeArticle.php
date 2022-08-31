<?php

namespace App\Entity;

use App\Repository\DetailCommandeArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailCommandeArticleRepository::class)
 */
class DetailCommandeArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="detailCommandeArticles")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $facture;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $montantTotal;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="detailCommandeArticles")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $article;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $montantTotalHorsTva;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $montantTva;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

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

    public function getMontantTotalHorsTva(): ?float
    {
        return $this->montantTotalHorsTva;
    }

    public function setMontantTotalHorsTva(float $montantTotalHorsTva): self
    {
        $this->montantTotalHorsTva = $montantTotalHorsTva;

        return $this;
    }

    public function getMontantTva(): ?float
    {
        return $this->montantTva;
    }

    public function setMontantTva(float $montantTva): self
    {
        $this->montantTva = $montantTva;

        return $this;
    }
}
