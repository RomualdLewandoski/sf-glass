<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getSponsoAllGenre()
    {
        return $this->createQueryBuilder('p')
            ->where('p.isSponso = :val')
            ->orderBy('p.id', 'DESC')
            ->setParameter('val', true)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function getSponsoByGender($gender)
    {
        return $this->createQueryBuilder('p')
            ->where('p.isSponso = :val')
            ->andWhere('p.gender = :gender')
            ->orderBy('p.id', 'DESC')
            ->setParameter('val', true)
            ->setParameter('gender', $gender)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function getLatest(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setParameter('val', true)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function getLatestGender($gender){
        return $this->createQueryBuilder('p')
            ->where('p.gender = :val')
            ->orderBy('p.id', 'DESC')
            ->setParameter('val', $gender)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
