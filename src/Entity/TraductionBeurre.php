<?php

namespace App\Entity;

use App\Repository\TraductionBeurreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraductionBeurreRepository::class)
 */
class TraductionBeurre
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
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="traductionBeurres")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity=Beurre::class, inversedBy="traductionBeurres")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $beurre;

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

    public function getBeurre(): ?Beurre
    {
        return $this->beurre;
    }

    public function setBeurre(?Beurre $beurre): self
    {
        $this->beurre = $beurre;

        return $this;
    }
}
