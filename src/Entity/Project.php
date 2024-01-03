<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\ErrorHandler\Collecting;

#[ORM\Entity()]
class Project{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"AUTO")]  
    #[ORM\Column()]
    private int $id;
    #[ORM\Column()]
    #[Assert\NotBlank(message:"The name can't be empty")]
    #[Assert\Length(min : 5,max : 70, minMessage:("The name is too short"), maxMessage:("The name is too long"))]
    private string $name;
    #[ORM\Column(type:"text")]
    #[Assert\NotBlank(message:"The description can't be empty")]
    #[Assert\Length(min : 10, max : 300, minMessage : ("The description is too short"), maxMessage : ("The description is too long"))]
    private string $description;
    #[ORM\Column(type:"date")]
    #[Assert\NotBlank(message : ("Date can't be empty"))]
    private $date;
    #[ORM\OneToMany(targetEntity:"App\Entity\Skill", mappedBy:"Project")]
    private Collection $skills; 

    #[ORM\Column(type: 'string')]
    private string $brochureFilename = "";

    public function __construct()
    {
        $this->skills= new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function setSkills(Collection $skills): self
    {
        $this->skills = $skills;

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