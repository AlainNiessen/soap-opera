<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    //configuration du bundle Vich dans config/packages/vich_uploader.yaml
    /**
     * @Vich\UploadableField(mapping="image_nom", fileNameProperty="nom")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="images")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="images")
     */
    private $article;

    /**
     * @ORM\Column(type="boolean")
     */
    private $layoutWebsite;

    /**
     * @ORM\ManyToOne(targetEntity=PositionImage::class, inversedBy="images")
     */
    private $positionImage;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $coverListArticle;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $coverDetailArticle;

    /**
     * @ORM\ManyToOne(targetEntity=PointDeVente::class, inversedBy="image")
     */
    private $pointDeVente;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom = null): self
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

    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt = null): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCoverListArticle(): ?bool
    {
        return $this->coverListArticle;
    }

    public function setCoverListArticle(?bool $coverListArticle): self
    {
        $this->coverListArticle = $coverListArticle;

        return $this;
    }

    

    public function getCoverDetailArticle(): ?bool
    {
        return $this->coverDetailArticle;
    }

    public function setCoverDetailArticle(?bool $coverDetailArticle): self
    {
        $this->coverDetailArticle = $coverDetailArticle;

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
