<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $dateAffichageStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAffichageEnd;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    
    /**
     * @ORM\Column(type="integer")
     */
    private $nombreLimit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documentPDF;

    //configuration du bundle Vich dans config/packages/vich_uploader.yaml
    /**
     * @Vich\UploadableField(mapping="event_documentPDF", fileNameProperty="documentPDF")
     * @var File
     */
    private $documentFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="event")
     */
    private $reservations;

    /**
     * @ORM\ManyToOne(targetEntity=TypeEvent::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeEvent;

    /**
     * @ORM\OneToMany(targetEntity=TraductionEvent::class, mappedBy="event")
     */
    private $traductionEvents;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="event")
     */
    private $images;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantHorsTva;

    /**
     * @ORM\Column(type="integer")
     */
    private $tauxTva;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->traductionEvents = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateAffichageStart(): ?\DateTimeInterface
    {
        return $this->dateAffichageStart;
    }

    public function setDateAffichageStart(\DateTimeInterface $dateAffichageStart): self
    {
        $this->dateAffichageStart = $dateAffichageStart;

        return $this;
    }

    public function getDateAffichageEnd(): ?\DateTimeInterface
    {
        return $this->dateAffichageEnd;
    }

    public function setDateAffichageEnd(\DateTimeInterface $dateAffichageEnd): self
    {
        $this->dateAffichageEnd = $dateAffichageEnd;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getNombreLimit(): ?int
    {
        return $this->nombreLimit;
    }

    public function setNombreLimit(int $nombreLimit): self
    {
        $this->nombreLimit = $nombreLimit;

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
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setEvent($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getEvent() === $this) {
                $reservation->setEvent(null);
            }
        }

        return $this;
    }

    public function getTypeEvent(): ?TypeEvent
    {
        return $this->typeEvent;
    }

    public function setTypeEvent(?TypeEvent $typeEvent): self
    {
        $this->typeEvent = $typeEvent;

        return $this;
    }

    /**
     * @return Collection<int, TraductionEvent>
     */
    public function getTraductionEvents(): Collection
    {
        return $this->traductionEvents;
    }

    public function addTraductionEvent(TraductionEvent $traductionEvent): self
    {
        if (!$this->traductionEvents->contains($traductionEvent)) {
            $this->traductionEvents[] = $traductionEvent;
            $traductionEvent->setEvent($this);
        }

        return $this;
    }

    public function removeTraductionEvent(TraductionEvent $traductionEvent): self
    {
        if ($this->traductionEvents->removeElement($traductionEvent)) {
            // set the owning side to null (unless already changed)
            if ($traductionEvent->getEvent() === $this) {
                $traductionEvent->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setEvent($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getEvent() === $this) {
                $image->setEvent(null);
            }
        }

        return $this;
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

    public function getTauxTva(): ?int
    {
        return $this->tauxTva;
    }

    public function setTauxTva(int $tauxTva): self
    {
        $this->tauxTva = $tauxTva;

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
