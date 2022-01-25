<?php

declare(strict_types=1);

use App\Repository\AppointmentRepository;
use App\Repository\LegalServiceRepository;
use App\Service\AppointmentStatisticsHelper;
use PHPUnit\Framework\TestCase;

class TesterTest extends TestCase
{
    /** @var LegalServiceRepository|mixed|\PHPUnit\Framework\MockObject\MockObject */
    private $legalServiceRepo;

    private AppointmentStatisticsHelper $statisticsHelper;

    /** @var AppointmentRepository|mixed|\PHPUnit\Framework\MockObject\MockObject */
    private $appointmentRepo;

    protected function setUp(): void
    {
        $this->legalServiceRepo = $this->createMock(LegalServiceRepository::class);
        $this->appointmentRepo = $this->createMock(AppointmentRepository::class);
    }

    public function testHallo(): void
    {
        $this->statisticsHelper = new AppointmentStatisticsHelper(
            $this->appointmentRepo,
            $this->legalServiceRepo
        );
        self::assertSame(true, true);
    }
}
