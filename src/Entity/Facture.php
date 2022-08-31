<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
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
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documentPDF;

    //configuration du bundle Vich dans config/packages/vich_uploader.yaml
    /**
     * @Vich\UploadableField(mapping="facture_documentPDF", fileNameProperty="documentPDF")
     * @var File
     */
    private $documentFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

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

    public function getDocumentPDF(): ?string
    {
        return $this->documentPDF;
    }

    public function setDocumentPDF(?string $documentPDF): self
    {
        $this->documentPDF = $documentPDF;

        return $this;
    }

    public function setDocumentFile(File $documentFile = null)
    {
        $this->documentFile = $documentFile;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($documentFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
