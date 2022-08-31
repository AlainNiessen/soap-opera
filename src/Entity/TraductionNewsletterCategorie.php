<?php

namespace App\Entity;

use App\Repository\TraductionNewsletterCategorieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraductionNewsletterCategorieRepository::class)
 */
class TraductionNewsletterCategorie
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="traductionNewsletterCategories")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity=NewsletterCategorie::class, inversedBy="traductionNewsletterCategories")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $newsletterCategories;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): self
    {
        $this->langue = $langue;

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
