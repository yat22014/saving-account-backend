<?php

namespace App\Repository;

use App\Entity\AccountDebt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AccountDebt|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountDebt|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountDebt[]    findAll()
 * @method AccountDebt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountDebtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountDebt::class);
    }

    // /**
    //  * @return AccountDebt[] Returns an array of AccountDebt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AccountDebt
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
