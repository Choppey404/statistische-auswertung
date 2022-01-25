<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use App\Repository\LegalServiceRepository;
use App\Service\AppointmentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/appointment/list")
 */
class AppointmentListController extends AbstractController
{
    private LegalServiceRepository $legalServiceRepository;
    private AppointmentManager $appointmentManager;

    public function __construct(
        LegalServiceRepository $legalServiceRepository,
        AppointmentManager $appointmentManager
    ) {
        $this->legalServiceRepository = $legalServiceRepository;
        $this->appointmentManager = $appointmentManager;
    }

    /** @Route("/", name="appointment_list_index", methods={"GET"}) */
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        return $this->render('appointment_list/list.html.twig', [
            'appointments' => $appointmentRepository->findAll(),
        ]);
    }

    /** @Route("/new", name="appointment_list_new", methods={"GET","POST"}) */
    public function new(Request $request): Response
    {
        $appointment = new Appointment();
        $legalServices = $this->legalServiceRepository->findAll();
        $form = $this->createForm(AppointmentType::class, $appointment, [
            'legalServiceId' => $legalServices,
        ]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $dateIsInvalid = AppointmentManager::ToDateIsInFuture($appointment->getFromDate(), $appointment->getToDate());
            if ($dateIsInvalid) {
                return $this->renderViolationForm(
                    'appointment_list/new.html.twig',
                    $appointment,
                    $form,
                    'Von Datum kann nicht nach Bis Datum liegen'
                );
            }
            $this->appointmentManager->persist($appointment);

            return $this->redirectToRoute('appointment_list_index');
        }

        return $this->renderForm('appointment_list/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    /** @Route("/{id}", name="appointment_list_show", methods={"GET"}) */
    public function show(Appointment $appointment): Response
    {
        return $this->render('appointment_list/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    /** @Route("/{id}/edit", name="appointment_list_edit", methods={"GET","POST"}) */
    public function edit(Request $request, Appointment $appointment): Response
    {
        $legalServices = $this->legalServiceRepository->findAll();
        $form = $this->createForm(AppointmentType::class, $appointment, [
            'legalServiceId' => $legalServices,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateIsInvalid = AppointmentManager::ToDateIsInFuture($appointment->getFromDate(), $appointment->getToDate());
            if ($dateIsInvalid) {
                return $this->renderViolationForm(
                    'appointment_list/edit.html.twig',
                    $appointment,
                    $form,
                    'Von Datum kann nicht nach Bis Datum liegen'
                );
            }
            $this->appointmentManager->persist($appointment);
            return $this->redirectToRoute('appointment_list_index');
        }

        return $this->renderForm('appointment_list/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    /** @Route("/{id}/delete", name="appointment_list_delete", methods={"GET", "POST"}) */
    public function delete(Request $request, Appointment $appointment): Response
    {
        $this->appointmentManager->delete($appointment);

        return $this->redirectToRoute('appointment_list_index', [], Response::HTTP_SEE_OTHER);
    }

    private function renderViolationForm(string $view, Appointment $appointment, FormInterface $form, string $violation): Response
    {
        return $this->renderForm($view, [
            'appointment' => $appointment,
            'form' => $form,
            'violation' => $violation,
        ]);
    }
}
