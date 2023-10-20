<?php

namespace App\Controller\Admin;

use App\Entity\Optional;
use App\Entity\Room;
use App\Repository\OptionalRepository;
use App\Repository\OptionRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Faker\Core\Number;

class RoomCrudController extends AbstractCrudController
{
    
    public static function getEntityFqcn(): string
    {
       
        return Room::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
        //  ImageField::new('picture'),
            TextField::new('name'),
            TextField::new('address'),
            NumberField::new('capacity'),
            NumberField::new('dayPrice'),
            BooleanField::new('isRentable'),
            ArrayField::new('optionals')
        ];
    }

}
