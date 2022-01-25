<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\LegalService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var array<LegalService> $legalServices */
        $legalServices = $options['legalServiceId'];

        $builder
            ->add(
                'fromDate',
                DateTimeType::class,
                [
                    'label' => 'Von',
                    'input' => 'datetime_immutable',
                ]
            )
            ->add(
                'toDate',
                DateTimeType::class,
                [
                    'label' => 'Bis',
                    'input' => 'datetime_immutable',
                ]
            );

        $builder->add(
            'legalService',
            ChoiceType::class,
            [
                'required' => true,
                'choices' => $legalServices,
                'placeholder' => 'Dienstleistung',
                'choice_label' => 'name',
                'label' => 'Dienstleistung',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
            'legalServiceId' => [],
        ]);

        $resolver->setAllowedTypes('legalServiceId', 'array');
    }
}
