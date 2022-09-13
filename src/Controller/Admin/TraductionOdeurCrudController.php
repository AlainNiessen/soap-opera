<?php

namespace App\Controller\Admin;

use App\Entity\TraductionOdeur;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield TextField::new('nom', new TranslatableMessage('option.tradOdeur_nom', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradOdeur_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('odeur', new TranslatableMessage('option.tradOdeur_odeur', [], 'EasyAdminBundle'));
    }
    
}
