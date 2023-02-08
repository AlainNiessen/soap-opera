<?php

namespace App\Controller\Admin;

use App\Entity\TraductionHuileEssentiel;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionHuileEssentielCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionHuileEssentiel::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['huileEssentiel' => 'DESC'])
            
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('huileEssentiel', new TranslatableMessage('option.tradhuileEss_langue', [], 'EasyAdminBundle'));
        yield TextField::new('nom', new TranslatableMessage('option.tradHuileEss_nom', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradHuileEss_langue', [], 'EasyAdminBundle'));
        
    }
    
}
