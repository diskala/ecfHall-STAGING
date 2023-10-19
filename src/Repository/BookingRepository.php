<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

       /**
    * @return count of Bookings - Returns an integer
    */
    public function findNotPrereservedBookings(): array
    {
 
             $prereservedBookings = $this->createQueryBuilder('b')
           ->andWhere('b.status <>:prereserved')
           ->andWhere('b.status <>:available')
             ->setParameter('prereserved', 2)
             ->setParameter('available', 1)
             ->orderBy('b.status', 'ASC')
            // ->OrderBy('b.startDate', 'desc')
             ->getQuery()
             ->getResult()
         ;
         
               
        return $prereservedBookings;
    }

       /**
    * @return count of Preserved - Returns an integer
    */
    public function findPrereservedBookings(): array
    {
 
             $prereservedBookings = $this->createQueryBuilder('b')
           ->andWhere('b.status =:prereserved')
             ->setParameter('prereserved', 2)
             ->orderBy('b.startDate', 'ASC')
             ->getQuery()
             ->getResult()
         ;
         
               
        return $prereservedBookings;
    }


//    /**
//     * @return Booking[] Returns an array of Booking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Booking
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
