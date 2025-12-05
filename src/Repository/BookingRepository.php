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
 

             $notPrereservedBookings = $this->createQueryBuilder('b')

           ->andWhere('b.status <>:prereserved')
           ->andWhere('b.status <>:available')
             ->setParameter('prereserved', 2)
             ->setParameter('available', 1)
             ->orderBy('b.status', 'ASC')
             ->addOrderBy('b.startDate', 'DESC')
             ->getQuery()
             ->getResult()
         ;
 
        return $notPrereservedBookings;

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

//Add an option to show an alert 5 days before the start date

public function findPrereservedBookingsAlert(): array
    { 
        $urgent=[];
        $bookings=$this->findPrereservedBookings();


        foreach ($bookings as $booking) {
            $startDate = $booking->getStartDate();
            $today = new \DateTime();
    
            if ($startDate->diff($today)->days <= 4) {
            $urgent[]=true;
                
            }
            else { 
                $urgent[]=false;
            }
        }

return $urgent;

    }

 /**
    * @return count of Bookings - Returns an integer
    */
    public function countBookingsByOwner($user): int
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

  
    // find all bookings for a room with status = 'Réservée' or 'Pré-réservée'
    // and endDate >= today
    // order by status DESC
    // and order by startDate ASC

    public function bookingsByDateByRoom(int $roomId, \DateTime $endDate): array
    {

             $bookings = $this->createQueryBuilder('b')
            ->where('b.endDate >= :dateFin')
            ->andWhere('b.room = :roomId')
            ->andWhere('b.status <> 1')
            ->andWhere('b.status <> 4')
            ->setParameter('dateFin', $endDate)
            ->setParameter('roomId', $roomId)
            ->orderBy('b.status', 'DESC')
            ->orderBy('b.startDate', 'ASC')
            ->getQuery()
            ->getResult()
         ;
          return $bookings;
    }

    /**
    * @return array of bookings
    */
    // find all bookings for a user 
    // with status = 'Réservée' or 'Pré-réservée' or 'Annulée'
    // order by endDate DESC
    // and order by status ASC
    public function bookingsByOwner(User $user): array
    {
             $bookings = $this->createQueryBuilder('b')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            //  ->where('b.endDate >= :dateFin')
            //  ->andWhere('b.room = :roomId')
            ->andWhere('b.status <> 1')
            //  ->andWhere('b.status <> 4')
            //  ->setParameter('dateFin', $endDate)
            //   ->setParameter('roomId', $roomId)
            ->orderBy('b.endDate', 'DESC')
            ->orderBy('b.status', 'ASC')
             ->getQuery()
             ->getResult()
         ;
          return $bookings;
    }


    /**
    * @return nb of bookings with statusId parameter
    * returns an integer
    */
    // find all bookings for a user 
    // with status parameter
    // order by endDate DESC
    // and order by status ASC
    public function bookingsByOwnerByStatus(User $user, $statusId): int
    {
             $bookings = $this->createQueryBuilder('b')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->andWhere('b.status = :statusId')
            ->setParameter('statusId', $statusId)
            ->orderBy('b.endDate', 'DESC')
            ->orderBy('b.status', 'ASC')
            ->getQuery()
            ->getResult()
         ;
          return count($bookings);
    }

}
