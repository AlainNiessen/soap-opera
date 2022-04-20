<?php

namespace App\Controller\Admin;

use App\Entity\IngredientSupplementaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IngredientSupplementaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IngredientSupplementaire::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
