<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
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
    private $dateReservation;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $facture;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantTotalHorsTva;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantTva;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantTotal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

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

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getMontantTotalHorsTva(): ?int
    {
        return $this->montantTotalHorsTva;
    }

    public function setMontantTotalHorsTva(int $montantTotalHorsTva): self
    {
        $this->montantTotalHorsTva = $montantTotalHorsTva;

        return $this;
    }

    public function getMontantTva(): ?int
    {
        return $this->montantTva;
    }

    public function setMontantTva(int $montantTva): self
    {
        $this->montantTva = $montantTva;

        return $this;
    }

    public function getMontantTotal(): ?int
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(int $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }
}
