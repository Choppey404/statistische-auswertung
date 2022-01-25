<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AppointmentStatisticsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private AppointmentStatisticsHelper $statisticsHelper;

    public function __construct(
        AppointmentStatisticsHelper $statisticsHelper
    ) {
        $this->statisticsHelper = $statisticsHelper;
    }

    /** @Route("/", name="dashboard") */
    public function list(): Response
    {
        $appointmentLengthData = $this->statisticsHelper->getAppointmentLengths();
        $appointmentDistributionData = $this->statisticsHelper->getAppointmentDistributionByLegalService();

        return $this->render(
            '/dashboard.html.twig',
            [
                'appointmentLengthData' => $appointmentLengthData,
                'appointmentDistributionData' => $appointmentDistributionData,
            ]
        );
    }
}
