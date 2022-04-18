<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="datetime")
     */
    private $dateNewsletter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $documentPDF;

    /**
     * @ORM\OneToMany(targetEntity=TraductionNewsletter::class, mappedBy="newsletter")
     */
    private $traductionNewsletters;

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

    public function getDocumentPDF(): ?string
    {
        return $this->documentPDF;
    }

    public function setDocumentPDF(string $documentPDF): self
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
}
