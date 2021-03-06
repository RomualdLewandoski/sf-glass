<?php

namespace App\Repository;

use App\Entity\CatProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CatProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatProduct::class);
    }

    public function findAll(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.placement', 'ASC')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return CatProduct[] Returns an array of CatProduct objects
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
    public function findOneBySomeField($value): ?CatProduct
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
