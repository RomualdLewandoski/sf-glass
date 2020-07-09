<?php

namespace App\Repository;

use App\Entity\GenderCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GenderCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenderCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenderCat[]    findAll()
 * @method GenderCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenderCatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenderCat::class);
    }

    // /**
    //  * @return GenderCat[] Returns an array of GenderCat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GenderCat
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
