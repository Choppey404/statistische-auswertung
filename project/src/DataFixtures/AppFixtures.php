<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\LegalService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const TOTAL_LEGAL_SERIVCES = 5;
    private const MIN_APPOINTMENTS_PER_LEGAL_SERVICE = 30;
    private const MAX_APPOINTMENTS_PER_LEGAL_SERVICE = 5;

    private LegalServiceBuilder $legalServiceBuilder;
    private AppointmentBuilder $appointmentBuilder;

    public function __construct(
        LegalServiceBuilder $legalServiceBuilder,
        AppointmentBuilder $appointmentBuilder
    ) {
        $this->legalServiceBuilder = $legalServiceBuilder;
        $this->appointmentBuilder = $appointmentBuilder;
    }

    public function load(ObjectManager $manager): void
    {
        $legalServices = $this->loadLegalServices($manager);
        $this->loadAppointments($manager, $legalServices);
    }

    /** @return array<LegalService> */
    private function loadLegalServices(ObjectManager $manager): array
    {
        $legalServices = [];
        for ($i = 0; $i < self::TOTAL_LEGAL_SERIVCES; $i++) {
            $legalService = $this->legalServiceBuilder->getLegalService($i);
            $legalServices[] = $legalService;
            $manager->persist($legalService);
        }
        $manager->flush();

        return $legalServices;
    }

    /** @param array<LegalService> $legalServices */
    private function loadAppointments(ObjectManager $manager, array $legalServices): void
    {
        foreach ($legalServices as $legalService) {
            $randomInt = \rand(self::MIN_APPOINTMENTS_PER_LEGAL_SERVICE, self::MAX_APPOINTMENTS_PER_LEGAL_SERVICE);
            for ($i = 0; $i < $randomInt; $i++) {
                $appointment = $this->appointmentBuilder->getAppointment();
                $appointment->setLegalService($legalService);
                $manager->persist($appointment);
            }
        }

        $manager->flush();
    }
}
