<?php

namespace App\Repository;

use App\Entity\Pertenece;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pertenece|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pertenece|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pertenece[]    findAll()
 * @method Pertenece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PerteneceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pertenece::class);
    }

//    /**
//     * @return Pertenece[] Returns an array of Pertenece objects
//     */
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
    public function findOneBySomeField($value): ?Pertenece
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
