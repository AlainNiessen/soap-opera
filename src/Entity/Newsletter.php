<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass=NewsletterRepository::class)
 */
class Newsletter
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
    private $nomBackend;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateNewsletter;

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
     * @ORM\OneToMany(targetEntity=TraductionNewsletter::class, mappedBy="newsletter")
     */
    private $traductionNewsletters;

    // function for display in admin interface
    public function __toString(): string
    {
        return $this->nomBackend;
    }

    public function __construct()
    {
        $this->traductionNewsletters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNewsletter(): ?\DateTimeInterface
    {
        return $this->dateNewsletter;
    }

    public function setDateNewsletter(\DateTimeInterface $dateNewsletter): self
    {
        $this->dateNewsletter = $dateNewsletter;

        return $this;
    }

    public function getNomBackend(): ?string
    {
        return $this->nomBackend;
    }

    public function setNomBackend(string $nomBackend): self
    {
        $this->nomBackend = $nomBackend;

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

    /**
     * @return Collection<int, TraductionNewsletter>
     */
    public function getTraductionNewsletters(): Collection
    {
        return $this->traductionNewsletters;
    }

    public function addTraductionNewsletter(TraductionNewsletter $traductionNewsletter): self
    {
        if (!$this->traductionNewsletters->contains($traductionNewsletter)) {
            $this->traductionNewsletters[] = $traductionNewsletter;
            $traductionNewsletter->setNewsletter($this);
        }

        return $this;
    }

    public function removeTraductionNewsletter(TraductionNewsletter $traductionNewsletter): self
    {
        if ($this->traductionNewsletters->removeElement($traductionNewsletter)) {
            // set the owning side to null (unless already changed)
            if ($traductionNewsletter->getNewsletter() === $this) {
                $traductionNewsletter->setNewsletter(null);
            }
        }

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
