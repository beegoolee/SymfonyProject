<?php

namespace App\Entity;

use App\Repository\ChatRepository;
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

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $members = null;

    #[ORM\Column]
    private ?int $owner_id = null;

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

    public function getMembers(): ?array
    {
        return $this->members;
    }

    public function setMembers(?array $members): static
    {
        $this->members = $members;

        return $this;
    }

    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    public function setOwnerId(int $owner_id): static
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    public function getChatOwner(): ?int
    {
        return $this->chat_owner;
    }

    public function setChatOwner(int $chat_owner): static
    {
        $this->chat_owner = $chat_owner;

        return $this;
    }
}
