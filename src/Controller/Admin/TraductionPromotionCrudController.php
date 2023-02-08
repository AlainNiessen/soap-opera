<?php

namespace App\Controller\Admin;

use App\Entity\TraductionPromotion;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionPromotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionPromotion::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['promotion' => 'DESC'])
            
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre', new TranslatableMessage('option.tradPromotion_titre', [], 'EasyAdminBundle'));
        yield TextField::new('description', new TranslatableMessage('option.tradPromotion_description', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradPromotion_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('promotion', new TranslatableMessage('option.tradPromotion_promotion', [], 'EasyAdminBundle'));
    }
    
}
