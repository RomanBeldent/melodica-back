<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavoriteRepository::class)
 */
class Favorite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favorites")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Band::class, mappedBy="favorite")
     */
    private $band;

    /**
     * @ORM\OneToMany(targetEntity=Organizer::class, mappedBy="favorite")
     */
    private $organizer;

    public function __construct()
    {
        $this->band = new ArrayCollection();
        $this->organizer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Band>
     */
    public function getBand(): Collection
    {
        return $this->band;
    }

    public function addBand(Band $band): self
    {
        if (!$this->band->contains($band)) {
            $this->band[] = $band;
            $band->setFavorite($this);
        }

        return $this;
    }

    public function removeBand(Band $band): self
    {
        if ($this->band->removeElement($band)) {
            // set the owning side to null (unless already changed)
            if ($band->getFavorite() === $this) {
                $band->setFavorite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Organizer>
     */
    public function getOrganizer(): Collection
    {
        return $this->organizer;
    }

    public function addOrganizer(Organizer $organizer): self
    {
        if (!$this->organizer->contains($organizer)) {
            $this->organizer[] = $organizer;
            $organizer->setFavorite($this);
        }

        return $this;
    }

    public function removeOrganizer(Organizer $organizer): self
    {
        if ($this->organizer->removeElement($organizer)) {
            // set the owning side to null (unless already changed)
            if ($organizer->getFavorite() === $this) {
                $organizer->setFavorite(null);
            }
        }

        return $this;
    }
}
