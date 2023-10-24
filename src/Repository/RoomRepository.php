<?php

namespace App\Repository;

use App\Entity\Optional;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Room>
 *
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

       /**
    * @return Room[] Returns an array of Room objects
    */
   public function findAvailByDate($startDate, $endDate): array
   {
    //SELECT * FROM room r WHERE r.id 
    //NOT IN (SELECT b.room_id FROM booking b 
    //WHERE b.startDate >= '2021-09-01' 
    //AND b.endDate <= '2021-09-30' 
    //AND b.status_id <> 4) ORDER BY r.name ASC

    $entityManager = $this->getEntityManager();
    
    $query = $entityManager->createQuery(
        'SELECT r
        FROM App\Entity\Room r
        WHERE r.id NOT IN(SELECT b.room FROM App\Entity\Booking b)
        ORDER BY r.name ASC');

// left join r.bookings
// WHERE r.id NOT IN(
//     SELECT b.room
//     FROM App\Entity\Booking b
//     WHERE b.startDate = :sdate
//     AND b.endDate = :edate
//     AND b.status <> 4)
    // )->setParameter('sdate', $startDate)
    // ->setParameter('edate', $endDate);
    dd($query->getResult());

    //returns an array of Room objects
    return $query->getResult();

   }


   public function searching($mots= null)
   {
     
       $query= $this->createQueryBuilder('r');
        
       if($mots != null)
       {
        
        $query->andWhere('MATCH_AGAINST(r.name, r.address) AGAINST(:mots BOOLEAN)>0')
        ->setParameter('mots', $mots );
        

       }


       return $query->getQuery()->getResult();

   }



   public function capacitie($capacity)
   {
    if($capacity != null)
    {
        $query= $this->createQueryBuilder('r');
     $query->andWhere('r.capacity> :cap')
        ->setParameter('cap', $capacity)
        ->orderBy('r.name');
        // dd($query->getDQL());

    }

    return $query->getQuery()->getResult();

   }




}
