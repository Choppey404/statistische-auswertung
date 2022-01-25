<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\LegalService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LegalService|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalService|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalService[]    findAll()
 * @method LegalService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalService::class);
    }
}
