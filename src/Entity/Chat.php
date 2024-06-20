<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chat_avatar = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $chat_owner = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'chats')]
    private Collection $Members;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'Chat', orphanRemoval: true)]
    private Collection $messages;

    #[ORM\Column(nullable: true)]
    private ?bool $isPrivate = null;

    public function __construct()
    {
        $this->Members = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getChatAvatar(): ?string
    {
        return $this->chat_avatar;
    }

    public function setChatAvatar(?string $chat_avatar): static
    {
        $this->chat_avatar = $chat_avatar;

        return $this;
    }

    public function getChatOwner(): ?User
    {
        return $this->chat_owner;
    }

    public function setChatOwner(?User $chat_owner): static
    {
        $this->chat_owner = $chat_owner;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMembers(): Collection
    {
        return $this->Members;
    }

    public function addMember(User $member): static
    {
        if (!$this->Members->contains($member)) {
            $this->Members->add($member);
        }

        return $this;
    }

    public function removeMember(User $member): static
    {
        $this->Members->removeElement($member);

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setChat($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getChat() === $this) {
                $message->setChat(null);
            }
        }

        return $this;
    }

    public function isPrivate(): ?bool
    {
        return $this->isPrivate;
    }

    public function setPrivate(?bool $isPrivate): static
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }
}
