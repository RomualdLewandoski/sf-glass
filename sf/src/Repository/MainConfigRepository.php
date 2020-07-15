<?php

namespace App\Repository;

use App\Entity\MainConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MainConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainConfig[]    findAll()
 * @method MainConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainConfig::class);
    }

    // /**
    //  * @return MainConfig[] Returns an array of MainConfig objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainConfig
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
