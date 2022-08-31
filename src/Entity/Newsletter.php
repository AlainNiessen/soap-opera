<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterRepository::class)
 */
class Newsletter
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
     * @ORM\Column(type="datetime")
     */
    private $dateNewsletter;    

    /**
     * @ORM\OneToMany(targetEntity=TraductionNewsletter::class, mappedBy="newsletter")
     */
    private $traductionNewsletters;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statutEnvoie = false;

    /**
     * @ORM\ManyToOne(targetEntity=NewsletterCategorie::class, inversedBy="newsletters")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $newsletterCategories;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    public function __construct()
    {
        $this->dateNewsletter = new \DateTime();
        $this->traductionNewsletters = new ArrayCollection();
        $this->traductionNewsletterCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNewsletter(): ?\DateTimeInterface
    {
        return $this->dateNewsletter;
    }

    public function setDateNewsletter(\DateTimeInterface $dateNewsletter): self
    {
        $this->dateNewsletter = $dateNewsletter;

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
            $traductionNewsletter->setNewsletter($this);
        }

        return $this;
    }

    public function removeTraductionNewsletter(TraductionNewsletter $traductionNewsletter): self
    {
        if ($this->traductionNewsletters->removeElement($traductionNewsletter)) {
            // set the owning side to null (unless already changed)
            if ($traductionNewsletter->getNewsletter() === $this) {
                $traductionNewsletter->setNewsletter(null);
            }
        }

        return $this;
    }

    public function getStatutEnvoie(): ?bool
    {
        return $this->statutEnvoie;
    }

    public function setStatutEnvoie(bool $statutEnvoie): self
    {
        $this->statutEnvoie = $statutEnvoie;

        return $this;
    }

    public function getNewsletterCategories(): ?NewsletterCategorie
    {
        return $this->newsletterCategories;
    }

    public function setNewsletterCategories(?NewsletterCategorie $newsletterCategories): self
    {
        $this->newsletterCategories = $newsletterCategories;

        return $this;
    }    
}
