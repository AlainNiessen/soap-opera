<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statutMenu;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="categorie")
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="categories")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity=TraductionCategorie::class, mappedBy="categorie")
     */
    private $traductionCategories;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="categorie")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBackend;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
        $this->traductionCategories = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatutMenu(): ?bool
    {
        return $this->statutMenu;
    }

    public function setStatutMenu(bool $statutMenu): self
    {
        $this->statutMenu = $statutMenu;

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
            $article->setCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategorie() === $this) {
                $article->setCategorie(null);
            }
        }

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }    

    /**
     * @return Collection<int, TraductionCategorie>
     */
    public function getTraductionCategories(): Collection
    {
        return $this->traductionCategories;
    }

    public function addTraductionCategory(TraductionCategorie $traductionCategory): self
    {
        if (!$this->traductionCategories->contains($traductionCategory)) {
            $this->traductionCategories[] = $traductionCategory;
            $traductionCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeTraductionCategory(TraductionCategorie $traductionCategory): self
    {
        if ($this->traductionCategories->removeElement($traductionCategory)) {
            // set the owning side to null (unless already changed)
            if ($traductionCategory->getCategorie() === $this) {
                $traductionCategory->setCategorie(null);
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
            $image->setCategorie($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCategorie() === $this) {
                $image->setCategorie(null);
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

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }
}
