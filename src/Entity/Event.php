<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"event_list", "event_show", "event_create", "event_update", "band_list", "band_show", "organizer_list", "organizer_show", "user_list", "user_show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"event_list", "event_show", "event_create", "event_update", "band_list", "band_show", "organizer_list", "organizer_show", "user_list", "user_show"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"event_list", "event_show", "event_create", "event_update", "band_list", "band_show", "organizer_list", "organizer_show", "user_list", "user_show"})
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Groups({"event_list", "event_show", "event_create", "event_update", "band_list", "band_show", "organizer_list", "organizer_show", "user_list", "user_show"})
     */
    private $date_start;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"event_list", "event_show", "event_create", "event_update", "band_list", "band_show", "organizer_list", "organizer_show", "user_list", "user_show"})
     */
    private $date_end;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"event_list", "event_show", "event_create", "event_update", "band_list", "band_show", "organizer_list", "organizer_show", "user_list", "user_show"})
     */
    private $hour_start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"event_list", "event_show", "event_create", "event_update", "band_list", "band_show", "organizer_list", "organizer_show", "user_list", "user_show"})
     */
    private $hour_end;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"event_list", "event_show", "event_create", "event_update"})
     */
    private $pictureFilename;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"event_list", "event_show", "event_create", "event_update"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"event_list", "event_show", "event_create", "event_update"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="events")
     * @Groups({"event_list", "event_show"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Band::class, inversedBy="events")
     * @Groups({"event_list", "event_show"})
     */
    private $bands;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="events",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"event_list", "event_show", "event_create", "event_update"})
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=Organizer::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"event_list", "event_show"})
     */
    private $organizer;


    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->bands = new ArrayCollection();
        $this->setCreatedAt(new DateTimeImmutable());
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getHourStart(): ?\DateTimeInterface
    {
        return $this->hour_start;
    }

    public function setHourStart(\DateTimeInterface $hour_start): self
    {
        $this->hour_start = $hour_start;

        return $this;
    }

    public function getHourEnd(): ?\DateTimeInterface
    {
        return $this->hour_end;
    }

    public function setHourEnd(?\DateTimeInterface $hour_end): self
    {
        $this->hour_end = $hour_end;

        return $this;
    }

    public function getPictureFilename(): ?string
    {
        return $this->pictureFilename;
    }

    public function setPictureFilename(string $pictureFilename): self
    {
        $this->pictureFilename = $pictureFilename;

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
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, Band>
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(Band $band): self
    {
        if (!$this->bands->contains($band)) {
            $this->bands[] = $band;
        }

        return $this;
    }

    public function removeBand(Band $band): self
    {
        $this->bands->removeElement($band);

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getOrganizer(): ?Organizer
    {
        return $this->organizer;
    }

    public function setOrganizer(?Organizer $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }
}
