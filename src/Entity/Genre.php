<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=GenreRepository::class)
 * @UniqueEntity("name", message = "Ce nom existe déjà") 
 */
class Genre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"genre_list", "genre_show"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"genre_list", "genre_show", "band_list", "band_show"})
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Band::class, mappedBy="genres")
     * @Groups({"genre_list", "genre_show"})
     */
    private $bands;

    public function __construct()
    {
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
            $band->addGenre($this);
        }

        return $this;
    }

    public function removeBand(Band $band): self
    {
        if ($this->bands->removeElement($band)) {
            $band->removeGenre($this);
        }

        return $this;
    }
}
