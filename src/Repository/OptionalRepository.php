<?php

namespace App\Repository;

use App\Entity\Optional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Optional>
 *
 * @method Optional|null find($id, $lockMode = null, $lockVersion = null)
 * @method Optional|null findOneBy(array $criteria, array $orderBy = null)
 * @method Optional[]    findAll()
 * @method Optional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Optional::class);
    }

//    /**
//     * @return Optional[] Returns an array of Optional objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Optional
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
