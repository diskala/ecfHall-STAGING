<?php

namespace App\Repository;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function __construct(ManagerRegistry $registry,EntityManagerInterface $entityManager)
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
    * @return status Preserved 
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

 /**
    * @return count of Bookings - Returns an integer
    */
    public function countBookingsByOwner(User $user): int
    {
 
             $bookings = $this->createQueryBuilder('b')
             ->andWhere('b.user = :user')
             ->setParameter('user', $user)
             ->orderBy('b.startDate', 'DESC')
             ->orderBy('b.status', 'ASC')
             ->getQuery()
             ->getResult()
         ;
         
               
        return count($bookings);
    }

    /**
    * @return array of bookings
    */
    public function bookingsByDateByRoom(int $roomId, \DateTime $endDate): array
    {

             $bookings = $this->createQueryBuilder('b')
             ->where('b.endDate >= :dateFin')
             ->andWhere('b.room = :roomId')
             ->andWhere('b.status <> 1')
             ->andWhere('b.status <> 4')
             ->setParameter('dateFin', $endDate)
              ->setParameter('roomId', $roomId)
             ->orderBy('b.startDate', 'ASC')
             ->orderBy('b.status', 'ASC')
             ->getQuery()
             ->getResult()
         ;
          return $bookings;
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
