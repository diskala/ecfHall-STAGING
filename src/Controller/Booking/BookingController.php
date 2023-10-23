<?php

namespace App\Controller\Booking;

use App\Entity\User;
use App\Entity\Booking;
use App\Repository\RoomRepository;
use App\Repository\BookingRepository;
use App\Repository\OptionalRepository;
use App\Repository\StatusRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/booking', name: 'app_booking_')]
class BookingController extends AbstractController
{
    private $optionalRepository;
    private $roomRepository;
    private $bookingRepository;
    private $statusRepository;

    public function __construct(OptionalRepository $optionalRepository, RoomRepository $roomRepository, BookingRepository $bookingRepository, StatusRepository $statusRepository)
    {
        $this->optionalRepository = $optionalRepository;
        $this->roomRepository = $roomRepository;
        $this->bookingRepository = $bookingRepository;
        $this->statusRepository = $statusRepository;
    }

    #[Route('/{id}', name: 'details')]
    public function details(Booking $booking): Response
    {
        $optionals = $this->optionalRepository->findAll();

        // if ($booking->getUser() !== $this->getUser()) {
        //     throw $this->createAccessDeniedException("Vous n'avez pas l'autorisation d'accéder à cette page");
        // }
        return $this->render('booking/details.html.twig', [
            'booking' => $booking,
            'listOptionals' => $optionals,
        ]);
    }

    //Route pour créer une réservation sur une salle
    #[Route('/room/{id}/new', name: 'newBooking')]
    public function newBooking(int $id): Response
    {
        //Today date
        $today = new \DateTime();
        $todayString = $today;
        //Find all status = 'Réservée' or 'Pré-réservée'
        $status = $this->statusRepository->findBy([
            'name'=> ['Réservée', 'Pré-réservée']
        ]);
        //Find a room by id
        $room =$this->roomRepository->findOneBy(['id' => $id]);
        
        //Find all bookings for this room 
        //with status = 'Réservée' or 'Pré-réservée'
        //and endDate >= today
        //order by startDate ASC
        $bookings2=$this->bookingRepository->bookingsByDateByRoom($room->getId(), $todayString);
        // $bookings=$this->bookingRepository->findBy([
        //     'room' => $room,
        //     'endDate' => ['>=' => $today],
        //     'status'=> $status,
        // ], ['startDate' => 'ASC']);

        return $this->render('booking/new.html.twig', [
            'room' => $room,
            'bookings' => $bookings2,
        ]);
    }
}
