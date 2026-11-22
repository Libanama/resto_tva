<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recette>
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    public function findByMoisAnneeUser(int $mois, int $annee, $user): array
    {
        $qb = $this->createQueryBuilder('r')
            ->where('MONTH(r.date) = :mois')
            ->andWhere('YEAR(r.date) = :annee')
            ->setParameter('mois', $mois)
            ->setParameter('annee', $annee)
            ->orderBy('r.date', 'ASC');

        if ($user !== null) {
            $qb->andWhere('r.user = :user')
               ->setParameter('user', $user);
        }

        return $qb->getQuery()->getResult();
    }
}