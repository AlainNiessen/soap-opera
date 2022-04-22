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
     * @ORM\Column(type="float", scale=2)
     */
    private $montantHorsTva;

    
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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBackend;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreVentes;

    /**
     * @ORM\OneToMany(targetEntity=DetailCommandeArticle::class, mappedBy="article")
     */
    private $detailCommandeArticles;

    /**
     * @ORM\Column(type="float")  
     */
    private $tauxTva;

    /**
     * @ORM\ManyToOne(targetEntity=Odeur::class, inversedBy="articles")
     */
    private $odeur;

    /**
     * @ORM\ManyToMany(targetEntity=Huile::class, inversedBy="articles")
     */
    private $huile;

    /**
     * @ORM\ManyToMany(targetEntity=HuileEssentiel::class, inversedBy="articles")
     */
    private $huileEssentiell;

    /**
     * @ORM\ManyToMany(targetEntity=Beurre::class, inversedBy="articles")
     */
    private $beurre;

    /**
     * @ORM\ManyToMany(targetEntity=IngredientSupplementaire::class, inversedBy="articles")
     */
    private $ingredientSupplementaire;

     // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->traductionArticles = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->detailCommandeArticles = new ArrayCollection();
        $this->huile = new ArrayCollection();
        $this->huileEssentiell = new ArrayCollection();
        $this->beurre = new ArrayCollection();
        $this->ingredientSupplementaire = new ArrayCollection();
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

    public function getNomBackend(): ?string
    {
        return $this->nomBackend;
    }

    public function setNomBackend(string $nomBackend): self
    {
        $this->nomBackend = $nomBackend;

        return $this;
    }

    public function getNombreVentes(): ?int
    {
        return $this->nombreVentes;
    }

    public function setNombreVentes(int $nombreVentes): self
    {
        $this->nombreVentes = $nombreVentes;

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
            $detailCommandeArticle->setArticle($this);
        }

        return $this;
    }

    public function removeDetailCommandeArticle(DetailCommandeArticle $detailCommandeArticle): self
    {
        if ($this->detailCommandeArticles->removeElement($detailCommandeArticle)) {
            // set the owning side to null (unless already changed)
            if ($detailCommandeArticle->getArticle() === $this) {
                $detailCommandeArticle->setArticle(null);
            }
        }

        return $this;
    }

    public function getTauxTva(): ?int
    {
        return $this->tauxTva;
    }

    public function setTauxTva(int $tauxTva): self
    {
        $this->tauxTva = $tauxTva;

        return $this;
    }

    public function getOdeur(): ?Odeur
    {
        return $this->odeur;
    }

    public function setOdeur(?Odeur $odeur): self
    {
        $this->odeur = $odeur;

        return $this;
    }

    /**
     * @return Collection<int, Huile>
     */
    public function getHuile(): Collection
    {
        return $this->huile;
    }

    public function addHuile(Huile $huile): self
    {
        if (!$this->huile->contains($huile)) {
            $this->huile[] = $huile;
        }

        return $this;
    }

    public function removeHuile(Huile $huile): self
    {
        $this->huile->removeElement($huile);

        return $this;
    }

    /**
     * @return Collection<int, HuileEssentiel>
     */
    public function getHuileEssentiell(): Collection
    {
        return $this->huileEssentiell;
    }

    public function addHuileEssentiell(HuileEssentiel $huileEssentiell): self
    {
        if (!$this->huileEssentiell->contains($huileEssentiell)) {
            $this->huileEssentiell[] = $huileEssentiell;
        }

        return $this;
    }

    public function removeHuileEssentiell(HuileEssentiel $huileEssentiell): self
    {
        $this->huileEssentiell->removeElement($huileEssentiell);

        return $this;
    }

    /**
     * @return Collection<int, Beurre>
     */
    public function getBeurre(): Collection
    {
        return $this->beurre;
    }

    public function addBeurre(Beurre $beurre): self
    {
        if (!$this->beurre->contains($beurre)) {
            $this->beurre[] = $beurre;
        }

        return $this;
    }

    public function removeBeurre(Beurre $beurre): self
    {
        $this->beurre->removeElement($beurre);

        return $this;
    }

    /**
     * @return Collection<int, IngredientSupplementaire>
     */
    public function getIngredientSupplementaire(): Collection
    {
        return $this->ingredientSupplementaire;
    }

    public function addIngredientSupplementaire(IngredientSupplementaire $ingredientSupplementaire): self
    {
        if (!$this->ingredientSupplementaire->contains($ingredientSupplementaire)) {
            $this->ingredientSupplementaire[] = $ingredientSupplementaire;
        }

        return $this;
    }

    public function removeIngredientSupplementaire(IngredientSupplementaire $ingredientSupplementaire): self
    {
        $this->ingredientSupplementaire->removeElement($ingredientSupplementaire);

        return $this;
    }
}
