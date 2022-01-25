<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\LegalService;

class LegalServiceBuilder
{
    private const NAMES = [
        'Kirchenaustritt',
        'Testamentrückgabe',
        'Erbausschlag',
        'Zwangsversteigerung',
        'Einsicht in das Grundbuch',
    ];
    public function getLegalService(int $index): LegalService
    {
        $index = $index % \count(self::NAMES); // prevent overflow

        $ls = new LegalService();
        $ls->setName(self::NAMES[$index]);

        return $ls;
    }
}
