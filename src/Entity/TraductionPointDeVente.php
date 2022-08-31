<?php

namespace App\Entity;

use App\Repository\TraductionPointDeVenteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraductionPointDeVenteRepository::class)
 */
class TraductionPointDeVente
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
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="traductionPointDeVentes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity=PointDeVente::class, inversedBy="traductionPointDeVentes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $pointDeVente;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getPointDeVente(): ?PointDeVente
    {
        return $this->pointDeVente;
    }

    public function setPointDeVente(?PointDeVente $pointDeVente): self
    {
        $this->pointDeVente = $pointDeVente;

        return $this;
    }
}
