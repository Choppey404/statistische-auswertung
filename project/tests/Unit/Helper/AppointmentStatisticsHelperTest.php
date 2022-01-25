<?php

declare(strict_types=1);


use App\Entity\Appointment;
use App\Entity\LegalService;
use App\Repository\AppointmentRepository;
use App\Repository\LegalServiceRepository;
use App\Service\AppointmentStatisticsHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AppointmentStatisticsHelperTest extends TestCase
{
    /** @var LegalServiceRepository|mixed|MockObject */
    private $legalServiceRepo;

    /** @var AppointmentRepository|mixed|MockObject */
    private $appointmentRepo;

    /** @var AppointmentStatisticsHelper $statisticsHelper */
    private $statisticsHelper;

    protected function setUp(): void
    {
        $this->legalServiceRepo = $this->createMock(LegalServiceRepository::class);
        $this->appointmentRepo = $this->createMock(AppointmentRepository::class);
        $this->statisticsHelper = new AppointmentStatisticsHelper(
            $this->appointmentRepo,
            $this->legalServiceRepo
        );
    }

    public function testGetAppointmentDistributionByLegalService(): void
    {
        $legalServices = [$this->getLegalService(22)];
        $this->legalServiceRepo
            ->method('findAll')
            ->willReturn($legalServices);
        $this->appointmentRepo
            ->method('getCountByLegalService')
            ->with($legalServices[0])
            ->willReturn([0 => [1 => 20]]);

        $result = $this->statisticsHelper->getAppointmentDistributionByLegalService();
        self::assertIsArray($result);
        self::assertSame([
            0 => [
                'legalService' => 'Dienstleistung',
                'count' => 20,
            ],
        ], $result);
    }

    public function testGetAppointmentLengths(): void
    {
        $this->appointmentRepo
            ->method('findAll')
            ->willReturn([$this->getAppointment(22)]);

        $result = $this->statisticsHelper->getAppointmentLengths()[0];
        dump($result);
        self::assertIsArray($result);
        self::assertStringContainsString('rgba(', $result['color']);
        self::assertSame(0, $result['count']);
    }

    private function getLegalService(int $id): LegalService
    {
        $legalService = new LegalService();
        $legalService->setId($id);
        $legalService->setName('Dienstleistung');

        return $legalService;
    }

    private function getAppointment(int $id): Appointment
    {
        $appointment = new Appointment();
        $appointment->setId($id);
        $appointment->setFromDate(DateTimeImmutable::createFromFormat('H:i', '11:30'));
        $appointment->setToDate(DateTimeImmutable::createFromFormat('H:i', '12:30'));
        return $appointment;
    }
}
