<?php

namespace App\Controller\Admin;

use App\Entity\Optional;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OptionalCrudController extends AbstractCrudController
{
    use Trait\readonlyTrait;
    public static function getEntityFqcn(): string
    {
        return Optional::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
