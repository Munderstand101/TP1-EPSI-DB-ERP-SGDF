<?php

namespace App\Entity;

use App\Repository\QualificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QualificationRepository::class)]
class Qualification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Chief::class, mappedBy: 'qualification')]
    private Collection $chiefs;

    public function __construct()
    {
        $this->chiefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Chief>
     */
    public function getChiefs(): Collection
    {
        return $this->chiefs;
    }

    public function addChief(Chief $chief): self
    {
        if (!$this->chiefs->contains($chief)) {
            $this->chiefs->add($chief);
            $chief->addQualification($this);
        }

        return $this;
    }

    public function removeChief(Chief $chief): self
    {
        if ($this->chiefs->removeElement($chief)) {
            $chief->removeQualification($this);
        }

        return $this;
    }
}
