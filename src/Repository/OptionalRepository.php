<?php

namespace App\Repository;

use App\Entity\Room;
use App\Entity\Optional;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

                  /**
    * @return Optionals[] Returns an array of Options objects
    */
    public function findOptionsByRoom(Room $room): array
    {
        $roomOptions = $this->createQueryBuilder('o')
        ->andWhere('o.id = :roomId')
        ->setParameter('roomId', $room->getId())
        ->groupBy('o.type')
        ->orderBy('o.name', 'ASC')
        ->getQuery()
        ->getResult()
    ;

    return $roomOptions;
    }

}
