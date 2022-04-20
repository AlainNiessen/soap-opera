<?php

namespace App\Controller\Admin;

use App\Entity\TraductionPartenaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionPartenaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionPartenaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('description', 'Beschreibung');
    }
    
}
