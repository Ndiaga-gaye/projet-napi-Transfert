<?php

namespace App\Repository;

use App\Entity\CreationCompte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CreationCompte|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreationCompte|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreationCompte[]    findAll()
 * @method CreationCompte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreationCompteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CreationCompte::class);
    }

    // /**
    //  * @return CreationCompte[] Returns an array of CreationCompte objects
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
    public function findOneBySomeField($value): ?CreationCompte
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
