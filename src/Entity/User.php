<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Пользователь с таким логином уже есть')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $second_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column]
    private bool $isVerified = false;

    public function getUserDisplayName()
    {
        return $this->getFirstName()?? $this->getEmail();
    }

    /**
     * @var Collection<int, WallPost>
     */
    #[ORM\OneToMany(targetEntity: WallPost::class, mappedBy: 'RelatedWallOwner', orphanRemoval: true)]
    private Collection $wallPosts;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'Friends')]
    private Collection $friends;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'friends')]
    private Collection $Friends;

    /**
     * @var Collection<int, Chat>
     */
    #[ORM\ManyToMany(targetEntity: Chat::class, mappedBy: 'Members')]
    #[ORM\OrderBy(['updatedAt' => 'DESC'])]
    private Collection $chats;

    public function __construct()
    {
        $this->wallPosts = new ArrayCollection();
        $this->friends = new ArrayCollection();
        $this->Friends = new ArrayCollection();
        $this->chats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->second_name;
    }

    public function setSecondName(?string $second_name): static
    {
        $this->second_name = $second_name;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar?? "img/nophoto.jpg";
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, WallPost>
     */
    public function getWallPosts(): Collection
    {
        return $this->wallPosts;
    }

    public function addWallPost(WallPost $wallPost): static
    {
        if (!$this->wallPosts->contains($wallPost)) {
            $this->wallPosts->add($wallPost);
            $wallPost->setRelatedWallOwner($this);
        }

        return $this;
    }

    public function removeWallPost(WallPost $wallPost): static
    {
        if ($this->wallPosts->removeElement($wallPost)) {
            // set the owning side to null (unless already changed)
            if ($wallPost->getRelatedWallOwner() === $this) {
                $wallPost->setRelatedWallOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(self $friend): static
    {
        if (!$this->friends->contains($friend)) {
            $this->friends->add($friend);
        }

        return $this;
    }

    public function removeFriend(self $friend): static
    {
        $this->friends->removeElement($friend);

        return $this;
    }

    /**
     * @return Collection<int, Chat>
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): static
    {
        if (!$this->chats->contains($chat)) {
            $this->chats->add($chat);
            $chat->addMember($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): static
    {
        if ($this->chats->removeElement($chat)) {
            $chat->removeMember($this);
        }

        return $this;
    }
}
