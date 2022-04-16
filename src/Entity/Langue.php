<?php

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LangueRepository::class)
 */
class Langue
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
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeLangue;

    /**
     * @ORM\OneToMany(targetEntity=TraductionCategorie::class, mappedBy="langue")
     */
    private $traductionCategories;

    /**
     * @ORM\OneToMany(targetEntity=TraductionTypeEvent::class, mappedBy="langue")
     */
    private $traductionTypeEvents;

    /**
     * @ORM\OneToMany(targetEntity=TraductionNewsletter::class, mappedBy="langue")
     */
    private $traductionNewsletters;

    /**
     * @ORM\OneToMany(targetEntity=TraductionPartenaire::class, mappedBy="langue")
     */
    private $traductionPartenaires;

    /**
     * @ORM\OneToMany(targetEntity=TraductionPromotion::class, mappedBy="langue")
     */
    private $traductionPromotions;

    /**
     * @ORM\OneToMany(targetEntity=TraductionArticle::class, mappedBy="langue")
     */
    private $traductionArticles;

    /**
     * @ORM\OneToMany(targetEntity=TraductionAdresse::class, mappedBy="langue")
     */
    private $traductionAdresses;

    /**
     * @ORM\OneToMany(targetEntity=TraductionEvent::class, mappedBy="langue")
     */
    private $traductionEvents;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="langue")
     */
    private $utilisateurs;

    public function __construct()
    {
        $this->traductionCategories = new ArrayCollection();
        $this->traductionTypeEvents = new ArrayCollection();
        $this->traductionNewsletters = new ArrayCollection();
        $this->traductionPartenaires = new ArrayCollection();
        $this->traductionPromotions = new ArrayCollection();
        $this->traductionArticles = new ArrayCollection();
        $this->traductionAdresses = new ArrayCollection();
        $this->traductionEvents = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getCodeLangue(): ?string
    {
        return $this->codeLangue;
    }

    public function setCodeLangue(string $codeLangue): self
    {
        $this->codeLangue = $codeLangue;

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
            $traductionCategory->setLangue($this);
        }

        return $this;
    }

    public function removeTraductionCategory(TraductionCategorie $traductionCategory): self
    {
        if ($this->traductionCategories->removeElement($traductionCategory)) {
            // set the owning side to null (unless already changed)
            if ($traductionCategory->getLangue() === $this) {
                $traductionCategory->setLangue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionTypeEvent>
     */
    public function getTraductionTypeEvents(): Collection
    {
        return $this->traductionTypeEvents;
    }

    public function addTraductionTypeEvent(TraductionTypeEvent $traductionTypeEvent): self
    {
        if (!$this->traductionTypeEvents->contains($traductionTypeEvent)) {
            $this->traductionTypeEvents[] = $traductionTypeEvent;
            $traductionTypeEvent->setLangue($this);
        }

        return $this;
    }

    public function removeTraductionTypeEvent(TraductionTypeEvent $traductionTypeEvent): self
    {
        if ($this->traductionTypeEvents->removeElement($traductionTypeEvent)) {
            // set the owning side to null (unless already changed)
            if ($traductionTypeEvent->getLangue() === $this) {
                $traductionTypeEvent->setLangue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionNewsletter>
     */
    public function getTraductionNewsletters(): Collection
    {
        return $this->traductionNewsletters;
    }

    public function addTraductionNewsletter(TraductionNewsletter $traductionNewsletter): self
    {
        if (!$this->traductionNewsletters->contains($traductionNewsletter)) {
            $this->traductionNewsletters[] = $traductionNewsletter;
            $traductionNewsletter->setLangue($this);
        }

        return $this;
    }

    public function removeTraductionNewsletter(TraductionNewsletter $traductionNewsletter): self
    {
        if ($this->traductionNewsletters->removeElement($traductionNewsletter)) {
            // set the owning side to null (unless already changed)
            if ($traductionNewsletter->getLangue() === $this) {
                $traductionNewsletter->setLangue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionPartenaire>
     */
    public function getTraductionPartenaires(): Collection
    {
        return $this->traductionPartenaires;
    }

    public function addTraductionPartenaire(TraductionPartenaire $traductionPartenaire): self
    {
        if (!$this->traductionPartenaires->contains($traductionPartenaire)) {
            $this->traductionPartenaires[] = $traductionPartenaire;
            $traductionPartenaire->setLangue($this);
        }

        return $this;
    }

    public function removeTraductionPartenaire(TraductionPartenaire $traductionPartenaire): self
    {
        if ($this->traductionPartenaires->removeElement($traductionPartenaire)) {
            // set the owning side to null (unless already changed)
            if ($traductionPartenaire->getLangue() === $this) {
                $traductionPartenaire->setLangue(null);
            }
        }

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
            $traductionPromotion->setLangue($this);
        }

        return $this;
    }

    public function removeTraductionPromotion(TraductionPromotion $traductionPromotion): self
    {
        if ($this->traductionPromotions->removeElement($traductionPromotion)) {
            // set the owning side to null (unless already changed)
            if ($traductionPromotion->getLangue() === $this) {
                $traductionPromotion->setLangue(null);
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
            $traductionArticle->setLangue($this);
        }

        return $this;
    }

    public function removeTraductionArticle(TraductionArticle $traductionArticle): self
    {
        if ($this->traductionArticles->removeElement($traductionArticle)) {
            // set the owning side to null (unless already changed)
            if ($traductionArticle->getLangue() === $this) {
                $traductionArticle->setLangue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionAdresse>
     */
    public function getTraductionAdresses(): Collection
    {
        return $this->traductionAdresses;
    }

    public function addTraductionAdress(TraductionAdresse $traductionAdress): self
    {
        if (!$this->traductionAdresses->contains($traductionAdress)) {
            $this->traductionAdresses[] = $traductionAdress;
            $traductionAdress->setLangue($this);
        }

        return $this;
    }

    public function removeTraductionAdress(TraductionAdresse $traductionAdress): self
    {
        if ($this->traductionAdresses->removeElement($traductionAdress)) {
            // set the owning side to null (unless already changed)
            if ($traductionAdress->getLangue() === $this) {
                $traductionAdress->setLangue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionEvent>
     */
    public function getTraductionEvents(): Collection
    {
        return $this->traductionEvents;
    }

    public function addTraductionEvent(TraductionEvent $traductionEvent): self
    {
        if (!$this->traductionEvents->contains($traductionEvent)) {
            $this->traductionEvents[] = $traductionEvent;
            $traductionEvent->setLangue($this);
        }

        return $this;
    }

    public function removeTraductionEvent(TraductionEvent $traductionEvent): self
    {
        if ($this->traductionEvents->removeElement($traductionEvent)) {
            // set the owning side to null (unless already changed)
            if ($traductionEvent->getLangue() === $this) {
                $traductionEvent->setLangue(null);
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
            $utilisateur->setLangue($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getLangue() === $this) {
                $utilisateur->setLangue(null);
            }
        }

        return $this;
    }
}
