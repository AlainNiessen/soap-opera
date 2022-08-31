<?php

namespace App\Entity;

use App\Repository\PhilosophieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhilosophieRepository::class)
 */
class Philosophie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $philosophie;

    /**
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="philosophies")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $langue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhilosophie(): ?string
    {
        return $this->philosophie;
    }

    public function setPhilosophie(string $philosophie): self
    {
        $this->philosophie = $philosophie;

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

    
}
