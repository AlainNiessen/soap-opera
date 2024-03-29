<?php

namespace App\Controller\Admin;

use App\Entity\TraductionBeurre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionBeurreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionBeurre::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['beurre' => 'DESC'])
            
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('beurre', new TranslatableMessage('option.tradBeurre_beurre', [], 'EasyAdminBundle'));
        yield TextField::new('nom', new TranslatableMessage('option.tradBeurre_nom', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradBeurre_langue', [], 'EasyAdminBundle'));
       
    }
    
}
