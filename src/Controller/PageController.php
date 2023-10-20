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

        //$aRooms = $entityManager->getRepository(Booking::class)->findAvailByDate('2023-10-20', '2023-10-21');
        $aRooms = $rRepo->findAll();
        $countBookings = $bookingRepository->countBookingsByOwner($this->getUser());
        return $this->render('page/about.html.twig', [
            'aRooms' => $aRooms,
            // 'countBookings' => $countBookings,
            'controller_name' => 'PageController',
            'user' => $this->getUser(),
            'countBookings' => $countBookings,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about()
    {

        return $this->render('page/about.html.twig');
    }
}