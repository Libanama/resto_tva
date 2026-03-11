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

    //    /**
    //     * @return Achat[] Returns an array of Achat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Achat
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
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
