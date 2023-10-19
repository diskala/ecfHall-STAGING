<?php

namespace App\Controller\Admin\trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

trait ReadonlyTrait
{
    public function configureActions(Actions $actions): Actions
    {
         
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
        // $actions->disable(Action::NEW, Action::EDIT, Action::DELETE);
        return $actions;
    }
}


?>