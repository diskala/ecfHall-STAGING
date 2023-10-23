<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Entity\Optional;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RoomCrudController extends AbstractCrudController
{


    // public static function getEntityOption(): string
    // {
    //     return Optional::class;
    // }



    public static function getEntityFqcn(): string
    {
        return Room::class;
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
            ImageField::new('picture')->setUploadDir('public/images/')->setUploadedFileNamePattern(
                fn (UploadedFile $file): string => sprintf('/images/salle_%s', 
                random_int(21, 999), $file->getFilename(), $file->guessExtension()))
,

// /images/salle_2.jpg

            TextField::new('name'),
            TextField::new('address'),
            NumberField::new('capacity'),
            NumberField::new('dayPrice'),
            BooleanField::new('isRentable'),
            // ArrayField::new('Optionals'),
            AssociationField::new('optionals')
            ->setFormTypeOption('choice_label','name')
            ->setFormTypeOption('by_reference',false),
          
          
            
       
        
        ];
    }
}
