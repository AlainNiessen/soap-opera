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
        yield TextField::new('rue', 'Strasse');
        yield TextField::new('numeroRue', 'Hausnummer');        
        yield TextField::new('codePostal', 'Postleitzahl');
        yield TextField::new('ville', 'Stadt');
        yield TextField::new('pays', 'Land');        
    }
}
