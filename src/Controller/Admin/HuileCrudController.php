<?php

namespace App\Controller\Admin;

use App\Entity\Huile;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HuileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Huile::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', 'Name für Adminbereich');
    }
    
}
