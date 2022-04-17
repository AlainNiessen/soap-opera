<?php

namespace App\Entity;

use App\Repository\TraductionHuileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraductionHuileRepository::class)
 */
class TraductionHuile
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
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="traductionHuiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity=Huile::class, inversedBy="traductionHuiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $huile;

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

    public function getHuile(): ?Huile
    {
        return $this->huile;
    }

    public function setHuile(?Huile $huile): self
    {
        $this->huile = $huile;

        return $this;
    }
}
