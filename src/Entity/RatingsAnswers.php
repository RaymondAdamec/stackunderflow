<?php

namespace App\Entity;

use App\Repository\RatingsAnswersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingsAnswersRepository::class)]
class RatingsAnswers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Votes = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Answers $fk_id_answers = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?User $fk_id_user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVotes(): ?int
    {
        return $this->Votes;
    }

    public function setVotes(int $Votes): static
    {
        $this->Votes = $Votes;

        return $this;
    }

    public function getFkIdAnswers(): ?Answers
    {
        return $this->fk_id_answers;
    }

    public function setFkIdAnswers(?Answers $fk_id_answers): static
    {
        $this->fk_id_answers = $fk_id_answers;

        return $this;
    }

    public function getFkIdUser(): ?User
    {
        return $this->fk_id_user;
    }

    public function setFkIdUser(?User $fk_id_user): static
    {
        $this->fk_id_user = $fk_id_user;

        return $this;
    }
}
