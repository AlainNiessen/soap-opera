<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', new TranslatableMessage('option.categorie_nomBackend', [], 'EasyAdminBundle'));
        yield ColorField::new('couleur', new TranslatableMessage('option.categorie_color', [], 'EasyAdminBundle')); 
        yield BooleanField::new('statutMenu',  new TranslatableMessage('option.categorie_statutMenu', [], 'EasyAdminBundle'));
        yield AssociationField::new('promotion', new TranslatableMessage('option.categorie_promotion', [], 'EasyAdminBundle'));
    }
    
}
