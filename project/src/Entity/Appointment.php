<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AppointmentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="datetime_immutable") */
    private DateTimeImmutable $fromDate;

    /** @ORM\Column(type="datetime_immutable") */
    private DateTimeImmutable $toDate;

    /**
     * @ORM\ManyToOne(targetEntity=LegalService::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $legalService;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFromDate(): ?DateTimeImmutable
    {
        return $this->fromDate;
    }

    public function setFromDate(?DateTimeImmutable $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?DateTimeImmutable
    {
        return $this->toDate;
    }

    public function setToDate(?DateTimeImmutable $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }

    public function getLegalService(): ?legalService
    {
        return $this->legalService;
    }

    public function setLegalService(?legalService $legalService): self
    {
        $this->legalService = $legalService;

        return $this;
    }
}
