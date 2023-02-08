<?php

namespace App\Controller\Admin;

use App\Entity\TraductionNewsletterCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionNewsletterCategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionNewsletterCategorie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['newsletterCategories' => 'DESC'])
            
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('newsletterCategories', new TranslatableMessage('option.tradNewsletterCategorie_newsletterCategorie', [], 'EasyAdminBundle'));
        yield TextField::new('nom', new TranslatableMessage('option.tradNewsletterCategorie_nom', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradNewsletterCategorie_langue', [], 'EasyAdminBundle'));
        
        
    }
    
}
