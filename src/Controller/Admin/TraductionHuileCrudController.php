<?php

namespace App\Controller\Admin;

use App\Entity\TraductionHuile;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionHuileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionHuile::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['huile' => 'DESC'])
            
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom', new TranslatableMessage('option.tradHuile_nom', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradHuile_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('huile', new TranslatableMessage('option.tradHuile_huile', [], 'EasyAdminBundle'));
    }
    
}
