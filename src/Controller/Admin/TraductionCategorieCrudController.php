<?php

namespace App\Controller\Admin;

use App\Entity\TraductionCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionCategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionCategorie::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom', 'Name');
        yield TextField::new('description', 'Beschreibung');
        yield AssociationField::new('langue', 'Sprache zuordnen');
        yield AssociationField::new('categorie', 'Kategorie zuordnen');
    }
    
}
