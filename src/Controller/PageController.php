<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\RoomRepository;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/userDashboard', name: 'app_userDashboard')]
    public function dashboard(BookingRepository $bookingRepository, RoomRepository $rRepo, Request $request): Response
    {

   
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
       
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
      
           
            // do anything else you need here, like send an email

            // return $userAuthenticator->authenticateUser(
            //     $user,
            //     $authenticator,
            //     $request
            // );
        }

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
            'searchForm'=>$form->createView()

        ]);


         
               
                
               
                
    

 
   
 
}

#[Route('/about', name: 'app_about')]
public function about()
{
    
    return $this->render('page/about.html.twig');
}


#[Route('/CGU', name: 'app_CGU')]
public function CGU()
{
    
    return $this->render('page/CGU.html.twig');
}


#[Route('/contact', name: 'app_contact')]
public function contact()
{
    
    return $this->render('page/contact.html.twig');
}

}

 
