<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $chat_id = null;

    #[ORM\Column(length: 1024)]
    private ?string $text = null;

    #[ORM\Column]
    private ?int $send_time = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatId(): ?int
    {
        return $this->chat_id;
    }
    public function setChatId(int $chat_id): static
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getSendTime(): ?int
    {
        return $this->send_time;
    }

    public function setSendTime(int $send_time): static
    {
        $this->send_time = $send_time;

        return $this;
    }

    public function getUserChatName()
    {
        $authorUser = $this->author;
        $this->user_chat_name = $authorUser->getFirstName()?? $authorUser->getEmail();

        return $this->user_chat_name;
    }

    public function getSendFormattedTime(): ?string
    {
        // TODO местное время, а не Мск
        date_default_timezone_set('Etc/GMT-3');
        $this->send_formatted_time = date("d M, H:i", $this->send_time);
        return $this->send_formatted_time;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }
}
