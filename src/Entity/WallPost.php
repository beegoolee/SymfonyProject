<?php

namespace App\Entity;

use App\Repository\WallPostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WallPostRepository::class)]
class WallPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'wallPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $RelatedWallOwner = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $PostAuthor = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $text = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelatedWallOwner(): ?User
    {
        return $this->RelatedWallOwner;
    }

    public function setRelatedWallOwner(?User $RelatedWallOwner): static
    {
        $this->RelatedWallOwner = $RelatedWallOwner;

        return $this;
    }

    public function getPostAuthor(): ?User
    {
        return $this->PostAuthor;
    }

    public function setPostAuthor(?User $PostAuthor): static
    {
        $this->PostAuthor = $PostAuthor;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }
}
