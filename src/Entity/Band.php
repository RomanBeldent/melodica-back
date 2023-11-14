<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BandRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BandRepository::class)
 */
class Band
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"band_list", "band_show", "user_list", "user_show", "random_all"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"band_list", "band_show", "band_create", "band_update", "event_list", "event_show", "user_list", "user_show", "random_all"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"band_list", "band_show", "band_create", "band_update", "event_list", "event_show", "user_list", "random_all"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"band_list", "band_show", "band_create", "band_update", "random_all"})
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"band_list", "band_show", "band_create", "band_update", "event_list", "event_show", "random_all"})
     */
    private $sample;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"user_show", "band_list", "band_show", "band_create", "band_update", "random_all"})
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"band_list", "band_show", "band_create", "band_update", "random_all"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="bands")
     * @Groups({"band_list", "band_show", "band_create", "band_update", "random_all"})
     */
    private $genres;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="band", cascade={"persist", "remove"})
     * @Groups({"band_show", "band_create", "band_update", "user_show"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="bands")
     * @Groups({"band_list", "band_show", "band_create", "band_update"})
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="bands")
     * @Groups({"band_list", "band_show", "band_create", "band_update", "user_list", "user_show", "random_all"})
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="bands")
     * @Groups({"band_list", "band_show", "band_create", "band_update", "random_all"})
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="band")
     */
    private $favorites;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getSample(): ?string
    {
        return $this->sample;
    }

    public function setSample(?string $sample): self
    {
        $this->sample = $sample;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
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
            $user->removeBand($this);
        }

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
            $event->addBand($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeBand($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeBand($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genres->removeElement($genre);

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
    //         $favorite->setBand($this);
    //     }

    //     return $this;
    // }

    // public function removeFavorite(Favorite $favorite): self
    // {
    //     if ($this->favorites->removeElement($favorite)) {
    //         // set the owning side to null (unless already changed)
    //         if ($favorite->getBand() === $this) {
    //             $favorite->setBand(null);
    //         }
    //     }

    //     return $this;
    // }
}
