<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'units')]
    private ?Group $group_ = null;


    #[ORM\OneToMany(mappedBy: 'unit', targetEntity: Chief::class)]
    private Collection $chiefs;

    #[ORM\OneToMany(mappedBy: 'unit', targetEntity: Scout::class)]
    private Collection $scouts;

    public function __construct()
    {
        $this->chiefs = new ArrayCollection();
        $this->scouts = new ArrayCollection();
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

    public function getGroup(): ?Group
    {
        return $this->group_;
    }

    public function setGroup(?Group $group_): self
    {
        $this->group_ = $group_;

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
            $chief->setUnit($this);
        }

        return $this;
    }

    public function removeChief(Chief $chief): self
    {
        if ($this->chiefs->removeElement($chief)) {
            // set the owning side to null (unless already changed)
            if ($chief->getUnit() === $this) {
                $chief->setUnit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Scout>
     */
    public function getScouts(): Collection
    {
        return $this->scouts;
    }

    public function addScout(Scout $scout): self
    {
        if (!$this->scouts->contains($scout)) {
            $this->scouts->add($scout);
            $scout->setUnit($this);
        }

        return $this;
    }

    public function removeScout(Scout $scout): self
    {
        if ($this->scouts->removeElement($scout)) {
            // set the owning side to null (unless already changed)
            if ($scout->getUnit() === $this) {
                $scout->setUnit(null);
            }
        }

        return $this;
    }
}
