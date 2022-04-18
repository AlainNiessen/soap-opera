<?php

namespace App\Entity;

use App\Repository\IngredientSupplementaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientSupplementaireRepository::class)
 */
class IngredientSupplementaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBackend;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="ingredientSupplementaire")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=TraductionIngredientSupplementaire::class, mappedBy="ingredientSupplementaire")
     */
    private $traductionIngredientSupplementaires;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->traductionIngredientSupplementaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $article->addIngredientSupplementaire($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removeIngredientSupplementaire($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionIngredientSupplementaire>
     */
    public function getTraductionIngredientSupplementaires(): Collection
    {
        return $this->traductionIngredientSupplementaires;
    }

    public function addTraductionIngredientSupplementaire(TraductionIngredientSupplementaire $traductionIngredientSupplementaire): self
    {
        if (!$this->traductionIngredientSupplementaires->contains($traductionIngredientSupplementaire)) {
            $this->traductionIngredientSupplementaires[] = $traductionIngredientSupplementaire;
            $traductionIngredientSupplementaire->setIngredientSupplementaire($this);
        }

        return $this;
    }

    public function removeTraductionIngredientSupplementaire(TraductionIngredientSupplementaire $traductionIngredientSupplementaire): self
    {
        if ($this->traductionIngredientSupplementaires->removeElement($traductionIngredientSupplementaire)) {
            // set the owning side to null (unless already changed)
            if ($traductionIngredientSupplementaire->getIngredientSupplementaire() === $this) {
                $traductionIngredientSupplementaire->setIngredientSupplementaire(null);
            }
        }

        return $this;
    }
}
