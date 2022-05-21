<?php

namespace App\Controller\Admin;

use App\Entity\TraductionIngredientSupplementaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionIngredientSupplementaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionIngredientSupplementaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom');
        yield AssociationField::new('langue');
        yield AssociationField::new('ingredientSupplementaire');
    }
    
}
