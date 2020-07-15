<?php

namespace App\Repository;

use App\Entity\ContactConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactConfig[]    findAll()
 * @method ContactConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactConfig::class);
    }

    // /**
    //  * @return ContactConfig[] Returns an array of ContactConfig objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactConfig
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
