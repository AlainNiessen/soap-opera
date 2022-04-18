<?php

namespace App\Entity;

use App\Repository\TraductionOdeurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraductionOdeurRepository::class)
 */
class TraductionOdeur
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
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="traductionOdeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity=Odeur::class, inversedBy="traductionOdeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $odeur;

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

    public function getOdeur(): ?Odeur
    {
        return $this->odeur;
    }

    public function setOdeur(?Odeur $odeur): self
    {
        $this->odeur = $odeur;

        return $this;
    }
}
