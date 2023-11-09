<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AddressRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"address_list", "address_show"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"address_list", "address_show", "band_list", "band_show", "band_create", "band_update", "address_create", "address_update", "organizer_list", "organizer_show", "organizer_create", "organizer_update", "event_list", "event_show", "event_create", "event_update"})
     * @Assert\NotBlank
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"address_list", "address_show", "band_list", "band_show", "band_create", "band_update", "address_create", "address_update", "organizer_list", "organizer_show", "organizer_create", "organizer_update", "event_list", "event_show", "event_create", "event_update"})
     * @Assert\NotBlank
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=85)
     * @Groups({"address_list", "address_show", "band_list", "band_show", "band_create", "band_update", "address_create", "address_update", "organizer_list", "organizer_show", "organizer_create", "organizer_update", "event_list", "event_show", "event_create", "event_update"})
     * @Assert\NotBlank
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"address_list", "address_show", "band_list", "band_show", "band_create", "band_update", "address_create", "address_update", "organizer_list", "organizer_show", "organizer_create", "organizer_update", "event_list", "event_show"})
     */
    private $department;

    /**
     * @ORM\OneToOne(targetEntity=Organizer::class, mappedBy="address", cascade={"persist", "remove"})
     * @Groups({"address_list", "address_show", "band_list", "band_show", "address_create", "address_update", "address_delete"})
     */
    private $organizer;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="address")
     * @Groups({"address_list", "address_show", "band_list", "band_show", "address_create", "address_update"})
     */
    private $events;

    /**
     * @ORM\OneToOne(targetEntity=Band::class, mappedBy="address", cascade={"persist", "remove"})
     * @Groups({"address_list", "address_show", "band_list", "band_show", "address_create", "address_update"})
     */
    private $band;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getOrganizer(): ?Organizer
    {
        return $this->organizer;
    }

    public function setOrganizer(Organizer $organizer): self
    {
        // set the owning side of the relation if necessary
        if ($organizer->getAddress() !== $this) {
            $organizer->setAddress($this);
        }

        $this->organizer = $organizer;

        return $this;
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
            $event->setAddress($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getAddress() === $this) {
                $event->setAddress(null);
            }
        }

        return $this;
    }

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(Band $band): self
    {
        // set the owning side of the relation if necessary
        if ($band->getAddress() !== $this) {
            $band->setAddress($this);
        }

        $this->band = $band;

        return $this;
    }
}
