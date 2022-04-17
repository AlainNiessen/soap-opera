<?php

namespace App\Entity;

use App\Repository\TraductionHuileEssentielRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraductionHuileEssentielRepository::class)
 */
class TraductionHuileEssentiel
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
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="traductionHuileEssentiels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity=HuileEssentiel::class, inversedBy="traductionHuileEssentiels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $huileEssentiel;

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

    public function getHuileEssentiel(): ?HuileEssentiel
    {
        return $this->huileEssentiel;
    }

    public function setHuileEssentiel(?HuileEssentiel $huileEssentiel): self
    {
        $this->huileEssentiel = $huileEssentiel;

        return $this;
    }
}
