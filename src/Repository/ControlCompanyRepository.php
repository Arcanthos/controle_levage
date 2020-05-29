<?php

namespace App\Repository;

use App\Entity\ControlCompany;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ControlCompany|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControlCompany|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControlCompany[]    findAll()
 * @method ControlCompany[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControlCompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ControlCompany::class);
    }

    // /**
    //  * @return ControlCompany[] Returns an array of ControlCompany objects
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
    public function findOneBySomeField($value): ?ControlCompany
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
