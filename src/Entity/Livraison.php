<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonRepository::class)
 */
class Livraison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantHorsTva;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $tauxTva;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantHorsTva(): ?int
    {
        return $this->montantHorsTva;
    }

    public function setMontantHorsTva(int $montantHorsTva): self
    {
        $this->montantHorsTva = $montantHorsTva;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getTauxTva(): ?float
    {
        return $this->tauxTva;
    }

    public function setTauxTva(float $tauxTva): self
    {
        $this->tauxTva = $tauxTva;

        return $this;
    }
}
