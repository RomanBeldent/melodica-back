<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrganizerRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=OrganizerRepository::class)
 * @UniqueEntity("name", message = "Ce nom de groupe ou d'artiste existe déjà")
 */
class Organizer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"organizer_list", "organizer_show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank
     * @Groups({"organizer_list", "organizer_show", "organizer_create", "organizer_update", "organizer_random", "user_list", "user_show", "event_list", "event_show"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Groups({"organizer_list", "organizer_show", "organizer_create", "organizer_update", "organizer_update", "organizer_random" ,"user_list", "user_show", "event_list", "event_show"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"organizer_list", "organizer_show", "organizer_create", "organizer_update", "organizer_random", "event_list", "event_show"})
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"organizer_list", "organizer_show", "organizer_create", "organizer_update", "organizer_random"})
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"organizer_list", "organizer_show", "organizer_create", "organizer_update", "organizer_random"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="organizers", cascade={"persist"})
     * @Groups({"organizer_list", "organizer_show"})
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="organizers", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"organizer_list", "organizer_show", "organizer_create", "organizer_update"})
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="organizer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"organizer_list", "organizer_show", "organizer_create", "organizer_update"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="organizer")
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="organizer")
     * @Groups({"organizer_list", "organizer_show", "user_list", "user_show"})
     */
    private $events;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->setCreatedAt(new DateTimeImmutable());
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeOrganizer($this);
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    // /**
    //  * @return Collection<int, Favorite>
    //  */
    // public function getFavorites(): Collection
    // {
    //     return $this->favorites;
    // }

    // public function addFavorite(Favorite $favorite): self
    // {
    //     if (!$this->favorites->contains($favorite)) {
    //         $this->favorites[] = $favorite;
    //         $favorite->setOrganizer($this);
    //     }

    //     return $this;
    // }

    // public function removeFavorite(Favorite $favorite): self
    // {
    //     if ($this->favorites->removeElement($favorite)) {
    //         // set the owning side to null (unless already changed)
    //         if ($favorite->getOrganizer() === $this) {
    //             $favorite->setOrganizer(null);
    //         }
    //     }

    //     return $this;
    // }

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
            $event->setOrganizer($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getOrganizer() === $this) {
                $event->setOrganizer(null);
            }
        }

        return $this;
    }
}
