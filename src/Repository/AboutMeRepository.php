<?php

namespace App\Repository;

use App\Entity\AboutMe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AboutMe|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutMe|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutMe[]    findAll()
 * @method AboutMe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutMeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutMe::class);
    }

    // /**
    //  * @return AboutMe[] Returns an array of AboutMe objects
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
    public function findOneBySomeField($value): ?AboutMe
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
