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
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="categorie")
     */
    private $promotions;

    /**
     * @ORM\ManyToMany(targetEntity=Partenaire::class, mappedBy="categorie")
     */
    private $partenaires;

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
            $promotion->setCategorie($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getCategorie() === $this) {
                $promotion->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Partenaire>
     */
    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaires->contains($partenaire)) {
            $this->partenaires[] = $partenaire;
            $partenaire->addCategorie($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->removeElement($partenaire)) {
            $partenaire->removeCategorie($this);
        }

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
}
