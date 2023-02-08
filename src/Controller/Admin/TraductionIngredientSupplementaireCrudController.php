<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\TraductionIngredientSupplementaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionIngredientSupplementaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionIngredientSupplementaire::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['ingredientSupplementaire' => 'DESC'])
            
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom', new TranslatableMessage('option.tradIng_nom', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradIng_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('ingredientSupplementaire', new TranslatableMessage('option.tradIng_ing', [], 'EasyAdminBundle'));
    }
    
}
