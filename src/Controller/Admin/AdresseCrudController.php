<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdresseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adresse::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('rue');
        yield TextField::new('numeroRue');        
        yield TextField::new('codePostal');
        yield TextField::new('ville');
        yield TextField::new('pays');        
    }
}
