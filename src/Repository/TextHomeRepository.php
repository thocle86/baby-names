<?php

namespace App\Repository;

use App\Entity\TextHome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TextHome|null find($id, $lockMode = null, $lockVersion = null)
 * @method TextHome|null findOneBy(array $criteria, array $orderBy = null)
 * @method TextHome[]    findAll()
 * @method TextHome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TextHomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TextHome::class);
    }

    // /**
    //  * @return TextHome[] Returns an array of TextHome objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TextHome
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
