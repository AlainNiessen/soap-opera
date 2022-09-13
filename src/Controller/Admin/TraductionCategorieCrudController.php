<?php

namespace App\Controller\Admin;

use App\Entity\TraductionCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
        yield TextField::new('nom', new TranslatableMessage('option.tradCategorie_nom', [], 'EasyAdminBundle'));
        yield TextEditorField::new('description', new TranslatableMessage('option.tradCategorie_description', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradcategorie_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('categorie', new TranslatableMessage('option.tradCategorie_categorie', [], 'EasyAdminBundle'));
    }
    
}
