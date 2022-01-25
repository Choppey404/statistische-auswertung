<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LegalServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LegalServiceRepository::class)
 */
class LegalService
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string", length=255) */
    private $name;

    /** @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="legalService") */
    private $appointments;

    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }

    /** @param mixed $id */
    public function setId($id): void
    {
        $this->id = $id;
    }


    public function setAppointments(ArrayCollection $appointments): void
    {
        $this->appointments = $appointments;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /** @return Collection|Appointment[] */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setLegalService($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getLegalService() === $this) {
                $appointment->setLegalService(null);
            }
        }

        return $this;
    }
}
