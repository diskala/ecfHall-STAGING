<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\SearchFormType;
use App\Repository\RoomRepository;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use ContainerH533Ec5\getRoomRepositoryService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/userDashboard', name: 'app_userDashboard')]
    public function dashboard(BookingRepository $bookingRepository, RoomRepository $rRepo,Request $request): Response
    {  

       


        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
        
        
       
        $aRooms = $rRepo->findAll();
        $motsRecherche = $form->get('motCles')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $motsCapacity=$form->get('capacity')->getData();
    
            if($motsRecherche != null)
            {
                // $motsRecherche = $form->get('motCles')->getData();
                
                $aRooms=$rRepo->searching($motsRecherche);
            }
    
           else
           {
                if($motsCapacity != null)
                {
                    // $motsRecherche = $form->get('motCles')->getData();
                    
                    $aRooms=$rRepo->capacitie($motsCapacity);
                    // dd($motsCapacity);
                }
    
                else
                {
                    
                
                    $aRooms = $rRepo->findAll();
                }
                
           }
           
            
           
            
           
            
      
            
        
        }
       


          


        // $aRooms = $rRepo->findAll();
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
            'searchForm' => $form->createView(),
           

        ]);


         
               
                
               
                
    

 
   
 
}
 

// #[Route('/search', name: 'app_userDashboard_search')]
// public function searchAction(Request $request, BookingRepository $bookRepo, RoomRepository $roomRepo)
// {


//     $form = $this->createForm(SearchFormType::class);
//     $form->handleRequest($request);
    
    
   
    
//     $motsRecherche = $form->get('motCles')->getData();
//     if ($form->isSubmitted() && $form->isValid()) {
//         $motsCapacity=$form->get('capacity')->getData();

//         if($motsRecherche != null)
//         {
//             // $motsRecherche = $form->get('motCles')->getData();
            
//             $aRooms=$roomRepo->searching($motsRecherche);
//         }

//        else
//        {
//             if($motsCapacity != null)
//             {
//                 // $motsRecherche = $form->get('motCles')->getData();
                
//                 $aRooms=$roomRepo->capacitie($motsCapacity);
//                 // dd($motsCapacity);
//             }

//             else
//             {
                
            
//                 $aRooms = $roomRepo->findAll();
//             }
            
//        }
       
        
       
        
       
        

        
    
//     }
   
  
//     // else
//     // {
//     //     $aRooms = $roomRepo->findAll();
//     // }
//     // dd($aRooms);
   
//     // $aRooms = $roomRepo->findAll();
    
//     // $aRooms=$roomRepo->searching($motsRecherche);
//     $countBookings = $bookRepo->countBookingsByOwner($this->getUser());
//     $bookings = $bookRepo->bookingsByOwner($this->getUser());
//     $reserved = $bookRepo->bookingsByOwnerByStatus($this->getUser(), 3);
//     $prereserved = $bookRepo->bookingsByOwnerByStatus($this->getUser(), 2);
//     $cancelled = $bookRepo->bookingsByOwnerByStatus($this->getUser(), 4);
//     return $this->render('page/search.html.twig', [
//         // 'searchForm' => $form->createView(),
        
//         'aRooms' => $aRooms,
//         'user' => $this->getUser(),
//         'countBookings' => $countBookings,
//         'bookings' => $bookings,
//         'reserved' => $reserved,
//         'prereserved' => $prereserved,
//         'cancelled' => $cancelled,
//     ]);
// }











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

 
