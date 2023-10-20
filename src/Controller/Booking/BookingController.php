<?php

namespace App\Controller\Booking;

use App\Entity\User;
use App\Entity\Booking;
use App\Repository\OptionalRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/booking', name: 'app_booking_')]
class BookingController extends AbstractController
{
    private $optionalRepository;

    public function __construct(OptionalRepository $optionalRepository)
    {
        $this->optionalRepository = $optionalRepository;
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
}
