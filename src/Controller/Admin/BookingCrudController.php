<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookingCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }


    public function configureActions(Actions $actions): Actions
{
    return $actions
        // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
    ;
}

    

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            // ImageField::new('picture'),
            TextField::new('eventType'),
            TextField::new('status'),
            TextField::new('room'),
            TextField::new('user.name'),
            DateField::new('startDate'),
            DateField::new('endDate'),
            NumberField::new('totalPrice'),
            TextField::new('comment'),
            // BooleanField::new('St'),
            // ArrayField::new('optionals')
        ];
    }
    
}
