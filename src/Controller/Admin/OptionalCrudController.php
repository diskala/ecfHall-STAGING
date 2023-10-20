<?php

namespace App\Controller\Admin;

use App\Entity\Optional;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OptionalCrudController extends AbstractCrudController
{
 
    public static function getEntityFqcn(): string
    {
        return Optional::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('type'),
            TextField::new('name'),
            TextField::new('description'),
            

        ];
    }
    
}
