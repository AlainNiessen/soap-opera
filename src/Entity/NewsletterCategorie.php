<?php

namespace App\Entity;

use App\Repository\NewsletterCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterCategorieRepository::class)
 */
class NewsletterCategorie
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
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="newsletterCategories")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity=TraductionNewsletterCategorie::class, mappedBy="newsletterCategories")
     */
    private $traductionNewsletterCategories;

    /**
     * @ORM\OneToMany(targetEntity=Newsletter::class, mappedBy="newsletterCategories", orphanRemoval=true)
     */
    private $newsletters;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->traductionNewsletterCategories = new ArrayCollection();
        $this->newsletters = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateurs->removeElement($utilisateur);

        return $this;
    }

    /**
     * @return Collection<int, TraductionNewsletterCategorie>
     */
    public function getTraductionNewsletterCategories(): Collection
    {
        return $this->traductionNewsletterCategories;
    }

    public function addTraductionNewsletterCategory(TraductionNewsletterCategorie $traductionNewsletterCategory): self
    {
        if (!$this->traductionNewsletterCategories->contains($traductionNewsletterCategory)) {
            $this->traductionNewsletterCategories[] = $traductionNewsletterCategory;
            $traductionNewsletterCategory->setNewsletterCategories($this);
        }

        return $this;
    }

    public function removeTraductionNewsletterCategory(TraductionNewsletterCategorie $traductionNewsletterCategory): self
    {
        if ($this->traductionNewsletterCategories->removeElement($traductionNewsletterCategory)) {
            // set the owning side to null (unless already changed)
            if ($traductionNewsletterCategory->getNewsletterCategories() === $this) {
                $traductionNewsletterCategory->setNewsletterCategories(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Newsletter>
     */
    public function getNewsletters(): Collection
    {
        return $this->newsletters;
    }

    public function addNewsletter(Newsletter $newsletter): self
    {
        if (!$this->newsletters->contains($newsletter)) {
            $this->newsletters[] = $newsletter;
            $newsletter->setNewsletterCategories($this);
        }

        return $this;
    }

    public function removeNewsletter(Newsletter $newsletter): self
    {
        if ($this->newsletters->removeElement($newsletter)) {
            // set the owning side to null (unless already changed)
            if ($newsletter->getNewsletterCategories() === $this) {
                $newsletter->setNewsletterCategories(null);
            }
        }

        return $this;
    }
}
