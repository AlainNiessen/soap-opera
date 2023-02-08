<?php

namespace App\Controller\Admin;

use App\Entity\TraductionPointDeVente;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionPointDeVenteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionPointDeVente::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['pointDeVente' => 'DESC'])
            
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('pointDeVente', new TranslatableMessage('option.tradPointDeVente_pointDeVente', [], 'EasyAdminBundle'));
        yield TextEditorField::new('description', new TranslatableMessage('option.tradPointDeVente_description', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradPointDeVente_langue', [], 'EasyAdminBundle'));
        
    }
    
}
