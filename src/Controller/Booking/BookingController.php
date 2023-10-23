<?php

namespace App\Controller\Booking;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Booking;
use App\Form\BookingFormType;
use Doctrine\ORM\EntityManager;
use App\Repository\RoomRepository;
use App\Repository\StatusRepository;
use App\Repository\BookingRepository;
use App\Repository\OptionalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/edition/{id}', name: 'details')]
    public function details(Booking $booking, Request $request, EntityManagerInterface $em): Response
    {
        if($booking->getStatus() == "Pré-réservée"){
        //Find a room by id
        $room =$this->roomRepository->findOneBy(['id' => $booking->getRoom()->getId()]);
        
        //$booking = $this->bookingRepository->findOneBy(['id' => $id]);

        //We create the form for the booking
        $bookingForm = $this->createForm(BookingFormType::class, $booking);

        $roomOptions = $this->optionalRepository->findOptionsByRoom($room);

        //We handle the request
        $bookingForm->handleRequest($request);

        //If the form is submitted and valid
        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {

            //We set the status of the booking
            //to 'Pré-réservée'
            //$booking->setStatus($this->statusRepository->findOneBy(['name' => 'Pré-réservée']));

            //We set the total price of the booking
            //by calculating the number of days between
            //the start date and the end date
            //TODO LATER: remove week-end days from the calculation
            $nbDays = $booking->getEndDate()->diff($booking->getStartDate())->days;
            $booking->setTotalPrice($room->getDayPrice() * ($nbDays + 1));

            //We persist the booking
            $em->persist($booking);

            //We flush the booking
            $em->flush();

            //We add a flash message
            $this->addFlash('success', 'Votre pré-réservation a bien été modifiée
             et est soumise à validation par un administrateur. Vérifiez régulièrement 
             l\'état de votre réservation dans votre espace personnel.');
            
             //We redirect to the user's Dashboard page
            //return $this->redirectToRoute('app_booking_details', ['id' => $booking->getId()]);
            return $this->redirectToRoute('app_userDashboard');
        }

                //We render the booking/add.html.twig view
                return $this->render('booking/edit.html.twig', [
                    'bookingForm' => $bookingForm->createView(),
                    'room' => $room,
                    'roomOptions' => $roomOptions,
                ]);
        }else{
            return $this->redirectToRoute('app_userDashboard');
        }

    }

    //Route to add a prebooking on a room
    #[Route('/room/{id}/add', name: 'addBooking')]
    public function addBooking(int $id, Request $request, EntityManagerInterface $em): Response
    {
        //We create a new booking
        $booking = new Booking();

        //Today date
        $today = new \DateTime();
        $todayString = $today;
        //Find all status = 'Réservée' or 'Pré-réservée'
        // $status = $this->statusRepository->findBy([
        //     'name'=> ['Réservée', 'Pré-réservée']
        // ]);
        //Find a room by id
        $room =$this->roomRepository->findOneBy(['id' => $id]);

        $roomOptions = $this->optionalRepository->findOptionsByRoom($room);
        
        //Find all bookings for this room 
        //with status = 'Réservée' or 'Pré-réservée'
        //and endDate >= today
        //order by startDate ASC
        $bookingsOthers=$this->bookingRepository->bookingsByDateByRoom($room->getId(), $todayString);

        //We can set the room and the user
        //of the new booking
        $booking->setRoom($room)
                ->setUser($this->getUser());

        //We create the form for the booking
        $bookingForm = $this->createForm(BookingFormType::class, $booking);


        //We handle the request
        $bookingForm->handleRequest($request);

        //If the form is submitted and valid
        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {

            //We set the status of the booking
            //to 'Pré-réservée'
            $booking->setStatus($this->statusRepository->findOneBy(['name' => 'Pré-réservée']));

            //We set the total price of the booking
            //by calculating the number of days between
            //the start date and the end date
            //TODO LATER: remove week-end days from the calculation
            $nbDays = $booking->getEndDate()->diff($booking->getStartDate())->days;
            $booking->setTotalPrice($room->getDayPrice() * ($nbDays + 1));

            //We persist the booking
            $em->persist($booking);

            //We flush the booking
            $em->flush();

            //We add a flash message
            $this->addFlash('success', 'Votre pré-réservation a bien été prise en compte
             et est soumise à validation par un administrateur. Vérifiez régulièrement 
             l\'état de votre réservation dans votre espace personnel.');
            
             //We redirect to the user's Dashboard page
            //return $this->redirectToRoute('app_booking_details', ['id' => $booking->getId()]);
            return $this->redirectToRoute('app_userDashboard');
        }

        //We render the booking/add.html.twig view
        return $this->render('booking/add.html.twig', [
            'bookingForm' => $bookingForm->createView(),
            'room' => $room,
            'bookings' => $bookingsOthers,
            'roomOptions' => $roomOptions,
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
