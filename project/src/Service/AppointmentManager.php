<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Appointment;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class AppointmentManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function persist(Appointment $appointment): void
    {
        $this->entityManager->persist($appointment);
        $this->entityManager->flush();
    }

    public function delete(Appointment $appointment): void
    {
        $this->entityManager->remove($appointment);
        $this->entityManager->flush();
    }

    public static function ToDateIsInFuture(DateTimeImmutable $fromDate, DateTimeImmutable $toDate): bool
    {
        $diff = $fromDate->diff($toDate);
        return $diff->invert === 1;
    }
}
