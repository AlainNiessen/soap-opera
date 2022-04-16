<?php

namespace App\Entity;

use App\Repository\TypeEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeEventRepository::class)
 */
class TypeEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="typeEvent")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=TraductionTypeEvent::class, mappedBy="typeEvent")
     */
    private $traductionTypeEvents;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->traductionTypeEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setTypeEvent($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getTypeEvent() === $this) {
                $event->setTypeEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionTypeEvent>
     */
    public function getTraductionTypeEvents(): Collection
    {
        return $this->traductionTypeEvents;
    }

    public function addTraductionTypeEvent(TraductionTypeEvent $traductionTypeEvent): self
    {
        if (!$this->traductionTypeEvents->contains($traductionTypeEvent)) {
            $this->traductionTypeEvents[] = $traductionTypeEvent;
            $traductionTypeEvent->setTypeEvent($this);
        }

        return $this;
    }

    public function removeTraductionTypeEvent(TraductionTypeEvent $traductionTypeEvent): self
    {
        if ($this->traductionTypeEvents->removeElement($traductionTypeEvent)) {
            // set the owning side to null (unless already changed)
            if ($traductionTypeEvent->getTypeEvent() === $this) {
                $traductionTypeEvent->setTypeEvent(null);
            }
        }

        return $this;
    }
}
