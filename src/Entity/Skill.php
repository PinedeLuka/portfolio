<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity()]
class Skill{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"AUTO")]
    #[ORM\Column()]
    private int $id;
    #[ORM\Column()]
    #[Assert\NotBlank(message:"The name can't be empty")]
    private string $name;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Project", inversedBy:"Skill")]
    private Project $project;

    #[ORM\Column(type: 'string')]
    private string $brochureFilename = "";

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

    public function getBrochureFilename(): string
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename(string $brochureFilename): self
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }
}