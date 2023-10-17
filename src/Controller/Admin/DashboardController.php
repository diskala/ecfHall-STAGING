<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Entity\Option;
use App\Entity\Status;
use App\Entity\Booking;
use App\Entity\EventType;
use App\Entity\TypeOption;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
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
        return $this->render('admin/dashboard.html.twig');
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
        yield MenuItem::linkToCrud('Evènement', 'fas fa-font-awesome', EventType::class);
        yield MenuItem::linkToCrud('Type d\'option', 'fas fa-filter', TypeOption::class);
        yield MenuItem::linkToCrud('Option', 'fas fa-plus-minus', Option::class);
        yield MenuItem::linkToCrud('Statut', 'fas fa-hourglass', Status::class);
    }
}
