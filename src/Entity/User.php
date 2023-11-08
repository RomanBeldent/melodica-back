<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email", message = "Cet email existe déjà")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)

     * @Groups({"user_list", "user_show", "user_create", "user_update", "organizer_list", "organizer_show", "band_list", "band_show","message_list", "message_show","message_create"})
     * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank

     * @Groups({"user_list", "user_show", "user_create", "user_update", "organizer_list", "organizer_show", "band_list", "band_show","message_list", "message_show","message_create"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Groups({"user_list", "user_show", "user_create", "user_update"})
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     * @Groups({"user_list", "user_show", "user_create", "user_update", "organizer_list", "organizer_show", "band_list", "band_show", "band_create", "band_update"})
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     * @var string The hashed password
     * @Assert\NotBlank
     * @Groups({"user_create", "user_update"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Groups({"user_list", "user_show", "user_create", "user_update", "band_list", "band_show", "band_create", "band_update"})
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_list", "user_show", "user_create", "user_update"})
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     * @Groups({"user_list", "user_show", "user_create", "user_update"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Organizer::class, mappedBy="users")
     * @Groups({"user_list", "user_show", "user_create"})
     */
    private $organizers;

    /**
     * @ORM\ManyToMany(targetEntity=Band::class, mappedBy="users")
     * @Groups({"user_list", "user_show", "user_create"})
     */
    private $bands;

    /**
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="user", orphanRemoval=true)
     */
    private $favorites;

    /**
     * @ORM\Column(type="json", options={"default": "['ROLE_USER']"}))
     * @Groups({"user_list", "user_show"})
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender")
     */
    private $sentMessages;
    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="recipient")
     */
    private $receivedMessages;

    public function __construct()
    {
        $this->organizers = new ArrayCollection();
        $this->bands = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->sentMessages = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
        if($this->getCreatedAt() === null){
            $this->setCreatedAt(new DateTimeImmutable());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
        * @see PasswordAuthenticatedUserInterface
        */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

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
     * @return Collection<int, Organizer>
     */
    public function getOrganizers(): Collection
    {
        return $this->organizers;
    }

    public function addOrganizer(Organizer $organizer): self
    {
        if (!$this->organizers->contains($organizer)) {
            $this->organizers[] = $organizer;
            $organizer->addUser($this);
        }

        return $this;
    }

    public function removeOrganizer(Organizer $organizers): self
    {
        $this->organizers->removeElement($organizers);

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
            $band->addUser($this);
        }

        return $this;
    }

    public function removeBand(Band $band): self
    {
        $this->bands->removeElement($band);

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
    * Returning a salt is only needed, if you are not using a modern
    * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
    *
    * @see UserInterface
    */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getSentMessages(): Collection
    {
        return $this->sentMessages;
    }

    public function addSentMessage(Message $message): self
    {
        if (!$this->sentMessages->contains($message)) {
            $this->sentMessages[] = $message;
            $message->setSender($this);
        }

        return $this;
    }

    public function removeSentMessage(Message $message): self
    {
        if ($this->sentMessages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, Message>
     */
    public function getReceivedMessages(): Collection
    {
        return $this->receivedMessages;
    }

    public function addReceivedMessage(Message $message): self
    {
        if (!$this->receivedMessages->contains($message)) {
            $this->receivedMessages[] = $message;
            $message->setRecipient($this);
        }

        return $this;
    }

    public function removeReceivedMessage(Message $message): self
    {
        if ($this->receivedMessages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getRecipient() === $this) {
                $message->setRecipient(null);
            }
        }

        return $this;
    }
}
