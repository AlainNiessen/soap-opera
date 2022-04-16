<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
    private $montantHorsTva;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantTva;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enAvant;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="articles")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="article")
     */
    private $promotions;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, mappedBy="articles")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="article")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=TraductionArticle::class, mappedBy="article")
     */
    private $traductionArticles;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="article")
     */
    private $images;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->traductionArticles = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantHorsTva(): ?int
    {
        return $this->montantHorsTva;
    }

    public function setMontantHorsTva(int $montantHorsTva): self
    {
        $this->montantHorsTva = $montantHorsTva;

        return $this;
    }

    public function getMontantTva(): ?int
    {
        return $this->montantTva;
    }

    public function setMontantTva(int $montantTva): self
    {
        $this->montantTva = $montantTva;

        return $this;
    }

    public function getEnAvant(): ?bool
    {
        return $this->enAvant;
    }

    public function setEnAvant(bool $enAvant): self
    {
        $this->enAvant = $enAvant;

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
     * @return Collection<int, Promotion>
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->setArticle($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getArticle() === $this) {
                $promotion->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->addArticle($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getArticle() === $this) {
                $commentaire->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionArticle>
     */
    public function getTraductionArticles(): Collection
    {
        return $this->traductionArticles;
    }

    public function addTraductionArticle(TraductionArticle $traductionArticle): self
    {
        if (!$this->traductionArticles->contains($traductionArticle)) {
            $this->traductionArticles[] = $traductionArticle;
            $traductionArticle->setArticle($this);
        }

        return $this;
    }

    public function removeTraductionArticle(TraductionArticle $traductionArticle): self
    {
        if ($this->traductionArticles->removeElement($traductionArticle)) {
            // set the owning side to null (unless already changed)
            if ($traductionArticle->getArticle() === $this) {
                $traductionArticle->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setArticle($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticle() === $this) {
                $image->setArticle(null);
            }
        }

        return $this;
    }
}
