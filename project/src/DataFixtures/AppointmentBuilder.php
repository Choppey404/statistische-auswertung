<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Appointment;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppointmentBuilder
{
    private const APPOINTMENT_INTERVAL = [5, 10, 15, 20, 25, 30];
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; ++$i) {
            $manager->persist($this->getAppointment());
        }

        $manager->flush();
    }

    public function getAppointment(): Appointment
    {
        $appointmentFrom = DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween($startDate = '+1day', $endDate = '+10days'));
        $appointmentTo = $appointmentFrom->add(new DateInterval('PT' . self::APPOINTMENT_INTERVAL[\rand(0, 5)] . 'M'));
        $appointment = new Appointment();
        $appointment->setFromDate($appointmentFrom);
        $appointment->setToDate($appointmentTo);

        return $appointment;
    }
}
