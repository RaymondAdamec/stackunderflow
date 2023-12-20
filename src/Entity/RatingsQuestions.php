<?php

namespace App\Entity;

use App\Repository\RatingsQuestionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingsQuestionsRepository::class)]
class RatingsQuestions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Votes = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Questions $fk_id_question = null;

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

    public function getFkIdQuestion(): ?Questions
    {
        return $this->fk_id_question;
    }

    public function setFkIdQuestion(?Questions $fk_id_question): static
    {
        $this->fk_id_question = $fk_id_question;

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
