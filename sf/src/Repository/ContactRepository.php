<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }



    public function getUnread()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.isRead = :val')
            ->setParameter('val', false)
            ->getQuery()
            ->getResult();
    }

    public function getReply()
    {
        return $this->createQueryBuilder('c')
            ->where('c.reply IS NOT NULL')
            ->andWhere('c.isTrash = :trash')
            ->setParameter('trash', false)
            ->getQuery()
            ->getResult();
    }

    public function getMessages()
    {
        return $this->createQueryBuilder('c')
            ->where('c.isTrash = :val')
            ->setParameter('val', false)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getTrash()
    {
        return $this->createQueryBuilder('c')
            ->where('c.isTrash = :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return Contact[] Returns an array of Contact objects
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
    public function findOneBySomeField($value): ?Contact
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
