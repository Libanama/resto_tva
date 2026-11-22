<?php

namespace App\Repository;

use App\Entity\Achat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Achat>
 */
class AchatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Achat::class);
    }

    public function findByMoisAnneeUser(int $mois, int $annee, $user): array
    {
        $qb = $this->createQueryBuilder('a')
            ->where('MONTH(a.date) = :mois')
            ->andWhere('YEAR(a.date) = :annee')
            ->setParameter('mois', $mois)
            ->setParameter('annee', $annee)
            ->orderBy('a.date', 'ASC');

        if ($user !== null) {
            $qb->andWhere('a.user = :user')
               ->setParameter('user', $user);
        }

        return $qb->getQuery()->getResult();
    }
}