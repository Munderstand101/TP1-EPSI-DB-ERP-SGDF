<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity extends \App\Entity\PaymentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(nullable: true)]
    private ?int $fee = null;

    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: Payment::class)]
    private Collection $Payment;

    #[ORM\ManyToMany(targetEntity: Scout::class, mappedBy: 'Activity')]
    private Collection $scouts;

    public function __construct()
    {
        $this->Payment = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getFee(): ?int
    {
        return $this->fee;
    }

    public function setFee(?int $fee): self
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayment(): Collection
    {
        return $this->Payment;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->Payment->contains($payment)) {
            $this->Payment->add($payment);
            $payment->setActivity($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->Payment->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getActivity() === $this) {
                $payment->setActivity(null);
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
            $scout->addActivity($this);
        }

        return $this;
    }

    public function removeScout(Scout $scout): self
    {
        if ($this->scouts->removeElement($scout)) {
            $scout->removeActivity($this);
        }

        return $this;
    }
}
