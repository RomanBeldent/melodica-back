<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @UniqueEntity("name", message = "Cet tag existe déjà")  
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"tag_list", "tag_show", "band_list", "band_show", "event_list", "event_show", "band_create", "band_update"})
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="tags")
     */
    private $events;

    /**
     * 
     * @ORM\ManyToMany(targetEntity=Band::class, mappedBy="tags")
     */
    private $bands;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->bands = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->name;        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $event->addTag($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Band>
     */
    public function getBand(): Collection
    {
        return $this->bands;
    }

    public function addBand(Band $band): self
    {
        if (!$this->bands->contains($band)) {
            $this->bands[] = $band;
            $band->addTag($this);
        }

        return $this;
    }

    public function removeBand(Band $band): self
    {
        $this->bands->removeElement($band);

        return $this;
    }
}
