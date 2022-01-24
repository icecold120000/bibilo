<?php

namespace App\Repository;

use App\Entity\Bibliothecque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bibliothecque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bibliothecque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bibliothecque[]    findAll()
 * @method Bibliothecque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BibliothecqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bibliothecque::class);
    }

    // /**
    //  * @return Bibliothecque[] Returns an array of Bibliothecque objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bibliothecque
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
