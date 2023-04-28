<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $paymont_date = null;

    #[ORM\Column(nullable: true)]
    private ?int $amount = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'payments')]
    private ?PaymentType $payment_type = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'Payment')]
    private ?Activity $activity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymontDate(): ?\DateTimeInterface
    {
        return $this->paymont_date;
    }

    public function setPaymontDate(?\DateTimeInterface $paymont_date): self
    {
        $this->paymont_date = $paymont_date;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentType(): ?PaymentType
    {
        return $this->payment_type;
    }

    public function setPaymentType(?PaymentType $payment_type): self
    {
        $this->payment_type = $payment_type;

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }
}
