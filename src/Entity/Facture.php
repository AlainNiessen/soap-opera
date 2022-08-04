<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
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
    private $dateFacture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statutPaiement;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=DetailCommandeArticle::class, mappedBy="facture")
     */
    private $detailCommandeArticles;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $montantTotal;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $montantTotalTva;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $montantTotalHorsTva;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statutLivraison;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->detailCommandeArticles = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->dateFacture;
    }

    public function setDateFacture(\DateTimeInterface $dateFacture): self
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    public function getStatutPaiement(): ?bool
    {
        return $this->statutPaiement;
    }

    public function setStatutPaiement(bool $statutPaiement): self
    {
        $this->statutPaiement = $statutPaiement;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, DetailCommandeArticle>
     */
    public function getDetailCommandeArticles(): Collection
    {
        return $this->detailCommandeArticles;
    }

    public function addDetailCommandeArticle(DetailCommandeArticle $detailCommandeArticle): self
    {
        if (!$this->detailCommandeArticles->contains($detailCommandeArticle)) {
            $this->detailCommandeArticles[] = $detailCommandeArticle;
            $detailCommandeArticle->setFacture($this);
        }

        return $this;
    }

    public function removeDetailCommandeArticle(DetailCommandeArticle $detailCommandeArticle): self
    {
        if ($this->detailCommandeArticles->removeElement($detailCommandeArticle)) {
            // set the owning side to null (unless already changed)
            if ($detailCommandeArticle->getFacture() === $this) {
                $detailCommandeArticle->setFacture(null);
            }
        }

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

    public function getMontantTotalTva(): ?float
    {
        return $this->montantTotalTva;
    }

    public function setMontantTotalTva(float $montantTotalTva): self
    {
        $this->montantTotalTva = $montantTotalTva;

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

    public function getStatutLivraison(): ?bool
    {
        return $this->statutLivraison;
    }

    public function setStatutLivraison(bool $statutLivraison): self
    {
        $this->statutLivraison = $statutLivraison;

        return $this;
    }
}
