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

    //    /**
    //     * @return Recette[] Returns an array of Recette objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recette
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

public function findByMoisAnnee(int $mois, int $annee): array
{
    return $this->findByMoisAnneeUser($mois, $annee, null);
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
