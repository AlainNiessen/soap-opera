<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
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
     * @ORM\Column(type="float", scale=2)
     */
    private $montantHorsTva;

    /**
     * @ORM\Column(type="float", scale=2)
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

    public function getMontantHorsTva(): ?float
    {
        return $this->montantHorsTva;
    }

    public function setMontantHorsTva(float $montantHorsTva): self
    {
        $this->montantHorsTva = $montantHorsTva;

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
