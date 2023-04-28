<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $information = null;

    #[ORM\OneToMany(mappedBy: 'family', targetEntity: Scout::class)]
    private Collection $scouts;

    public function __construct()
    {
        $this->scouts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(?string $information): self
    {
        $this->information = $information;

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
            $scout->setFamily($this);
        }

        return $this;
    }

    public function removeScout(Scout $scout): self
    {
        if ($this->scouts->removeElement($scout)) {
            // set the owning side to null (unless already changed)
            if ($scout->getFamily() === $this) {
                $scout->setFamily(null);
            }
        }

        return $this;
    }
}
