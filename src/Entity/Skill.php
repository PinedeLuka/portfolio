<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Skill{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"AUTO")]
    #[ORM\Column()]
    private int $id;
    #[ORM\Column()]
    private string $name;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Project", inversedBy:"Skill")]
    private Project $project;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * Set the value of project
     */
    public function setProject(Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}