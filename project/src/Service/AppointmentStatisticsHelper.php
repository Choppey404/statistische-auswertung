<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Appointment;
use App\Repository\AppointmentRepository;
use App\Repository\LegalServiceRepository;
use DateInterval;

class AppointmentStatisticsHelper
{
    private AppointmentRepository $appointmentRepository;
    private LegalServiceRepository $legalServiceRepository;

    public function __construct(
        AppointmentRepository $appointmentRepository,
        LegalServiceRepository $legalServiceRepository
    ) {
        $this->appointmentRepository = $appointmentRepository;
        $this->legalServiceRepository = $legalServiceRepository;
    }

    /** @return array<int, int> */
    public function getAppointmentLengths(): array
    {
        /** @var array<Appointment> $appointments */
        $appointments = $this->appointmentRepository->findAll();

        $appointmentLengths = [];
        foreach ($appointments as $appointment) {
            $diff = $appointment->getToDate()->diff($appointment->getFromDate());
            $minutes = $this->calculateToMinutes($diff);
            $minutesRounded = $this->roundToNextTact($minutes);

            if (!isset($appointmentLengths[$minutesRounded])) {
                $appointmentLengths[$minutesRounded]['count'] = 0;
                $appointmentLengths[$minutesRounded]['color'] = $this->getRandomColor();
            } else {
                $appointmentLengths[$minutesRounded]['count']++;
            }
        }
        \ksort($appointmentLengths);

        return $appointmentLengths;
    }

    /** @return array<string, string|int> */
    public function getAppointmentDistributionByLegalService(): array
    {
        $appointmentDistributionData = [];
        $legalServices = $this->legalServiceRepository->findAll();
        foreach ($legalServices as $legalService) {
            $appointmentCount = \current($this->appointmentRepository->getCountByLegalService($legalService));
            $appointmentDistributionData[] = [
                'legalService' => $legalService->getName(),
                'count' => $appointmentCount[1],
            ];
        }
        return $appointmentDistributionData;
    }

    private function getRandomColor(): string
    {
        $hash = \md5(\random_bytes(32));
        $rgb = [
            \hexdec(\substr($hash, 0, 2)), // r
            \hexdec(\substr($hash, 2, 2)), // g
            \hexdec(\substr($hash, 4, 2)), // b
        ];

        return 'rgba(' . \implode(',', $rgb) . ',0.3)';
    }

    private function roundToNextTact(int $diff): int
    {
        $diffToNextTact = $diff % 5;
        return ($diffToNextTact > 2) ? $diff + (5 - $diffToNextTact) : $diff - $diffToNextTact;
    }

    private function calculateToMinutes(DateInterval $diff): int
    {
        $minutes = $diff->days * 24 * 60;
        $minutes += $diff->h * 60;
        $minutes += $diff->i;

        // adjust to the highest tact
        if ($minutes > 30) {
            $minutes = 30;
        }
        return $minutes;
    }
}
