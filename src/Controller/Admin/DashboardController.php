<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Status;
use App\Entity\Booking;
use App\Entity\Optional;
use App\Entity\EventType;
use App\Entity\TypeOption;
use App\Repository\BookingRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    protected $bookingRepository;
    protected $statusRepository;
    protected $entityManager;

    public function __construct(
        BookingRepository $bookingRepository, StatusRepository $statusRepository, EntityManagerInterface $entityManager
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->statusRepository = $statusRepository;
        $this->entityManager = $entityManager;
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {  


        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //


       return $this->render('admin/dashboard.html.twig',[
        'Prereserved'=> $this->bookingRepository->findPrereservedBookings(),
        'NotPrereserved'=>$this->bookingRepository->findNotPrereservedBookings(),
        'urgent'=>$this->bookingRepository->findPrereservedBookingsAlert(),
        
        

       ]);
    
    }

    #[Route('/admin/booking/{id}/update-status', name: 'admin_update_booking_status', methods: ['POST'])]
    public function updateBookingStatus(Request $request, EntityManagerInterface $entityManager, int $id)
    {
        $formData = $request->request->all();

        

        $booking = $this->bookingRepository->findOneBy(
            ['id'=>$id]);
            if ($formData ['btn'] == 'accepted') {
                $status = $this->statusRepository->findOneBy(
                    ['name'=>'Réservée']);
                $booking->setStatus($status) ;
            } 
            else {
                $status = $this->statusRepository->findOneBy(
                    ['name'=>'Annulée']);
                $booking->setStatus($status) ;

            }


    $entityManager->persist($booking);
    $entityManager->flush();

        return $this->redirectToRoute('admin');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        -> setTitle('<img src="/images/logo.png">');   
    }

    

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Réservation', 'fas fa-calendar', Booking::class);
        yield MenuItem::linkToCrud('Salle', 'fas fa-people-roof', Room::class);
        yield MenuItem::linkToCrud('Client', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Evènement', 'fas fa-font-awesome', EventType::class);
        yield MenuItem::linkToCrud('Type d\'option', 'fas fa-filter', TypeOption::class);
        yield MenuItem::linkToCrud('Option', 'fas fa-plus-minus', Optional::class);
        yield MenuItem::linkToCrud('Statut', 'fas fa-hourglass', Status::class);
    }

   
  

  
}