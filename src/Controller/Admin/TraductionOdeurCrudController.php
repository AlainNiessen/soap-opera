<?php

namespace App\Controller\Admin;

use App\Entity\TraductionOdeur;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionOdeurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionOdeur::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom', 'Name');
        yield AssociationField::new('langue', 'Sprache zuordnen');
        yield AssociationField::new('odeur', 'Duft zuordnen');
    }
    
}
