<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/userDashboard', name: 'app_userDashboard')]
    public function dashboard(BookingRepository $bookingRepository, RoomRepository $rRepo): Response
    {

        $aRooms = $rRepo->findAll();
        $countBookings = $bookingRepository->countBookingsByOwner($this->getUser());
        $bookings = $bookingRepository->bookingsByOwner($this->getUser());
        $reserved = $bookingRepository->bookingsByOwnerByStatus($this->getUser(), 3);
        $prereserved = $bookingRepository->bookingsByOwnerByStatus($this->getUser(), 2);
        $cancelled = $bookingRepository->bookingsByOwnerByStatus($this->getUser(), 4);
        return $this->render('page/userDashboard.html.twig', [
            'aRooms' => $aRooms,
            'user' => $this->getUser(),
            'countBookings' => $countBookings,
            'bookings' => $bookings,
            'reserved' => $reserved,
            'prereserved' => $prereserved,
            'cancelled' => $cancelled,

        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about()
    {

        return $this->render('page/about.html.twig');
    }
}