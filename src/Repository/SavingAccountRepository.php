<?php

namespace App\Repository;

use App\Entity\SavingAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SavingAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavingAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavingAccount[]    findAll()
 * @method SavingAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavingAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavingAccount::class);
    }

    // /**
    //  * @return SavingAccount[] Returns an array of SavingAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SavingAccount
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
