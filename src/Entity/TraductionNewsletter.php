<?php

namespace App\Entity;

use App\Repository\TraductionNewsletterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass=TraductionNewsletterRepository::class)
 */
class TraductionNewsletter
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documentPDF;

    //configuration du bundle Vich dans config/packages/vich_uploader.yaml
    /**
     * @Vich\UploadableField(mapping="newsletter_documentPDF", fileNameProperty="documentPDF")
     * @var File
     */
    private $documentFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="traductionNewsletters")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity=Newsletter::class, inversedBy="traductionNewsletters")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $newsletter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
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

    public function getNewsletter(): ?Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(?Newsletter $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getDocumentPDF(): ?string
    {
        return $this->documentPDF;
    }

    public function setDocumentPDF(string $documentPDF = null): self
    {
        $this->documentPDF = $documentPDF;

        return $this;
    }

    public function setDocumentFile(File $documentFile = null)
    {
        $this->documentFile = $documentFile;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($documentFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getDocumentFile()
    {
        return $this->documentFile;
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
}
