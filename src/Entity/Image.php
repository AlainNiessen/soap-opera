<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
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
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="images")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="images")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Partenaire::class, inversedBy="images")
     */
    private $partenaire;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="images")
     */
    private $event;

    /**
     * @ORM\Column(type="boolean")
     */
    private $layoutWebsite;

    /**
     * @ORM\ManyToOne(targetEntity=PositionImage::class, inversedBy="images")
     */
    private $positionImage;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getLayoutWebsite(): ?bool
    {
        return $this->layoutWebsite;
    }

    public function setLayoutWebsite(bool $layoutWebsite): self
    {
        $this->layoutWebsite = $layoutWebsite;

        return $this;
    }

    public function getPositionImage(): ?PositionImage
    {
        return $this->positionImage;
    }

    public function setPositionImage(?PositionImage $positionImage): self
    {
        $this->positionImage = $positionImage;

        return $this;
    }
}
