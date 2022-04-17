<?php

namespace App\Entity;

use App\Repository\TraductionIngredientSupplementaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraductionIngredientSupplementaireRepository::class)
 */
class TraductionIngredientSupplementaire
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
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="traductionIngredientSupplementaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity=IngredientSupplementaire::class, inversedBy="traductionIngredientSupplementaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ingredientSupplementaire;

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

    public function getIngredientSupplementaire(): ?IngredientSupplementaire
    {
        return $this->ingredientSupplementaire;
    }

    public function setIngredientSupplementaire(?IngredientSupplementaire $ingredientSupplementaire): self
    {
        $this->ingredientSupplementaire = $ingredientSupplementaire;

        return $this;
    }
}
