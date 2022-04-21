<?php

namespace App\Controller\Admin;

use App\Entity\TraductionPromotion;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionPromotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionPromotion::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre', 'Name');
        yield TextField::new('description', 'Beschreibung');
        yield AssociationField::new('langue', 'Sprache zuordnen');
        yield AssociationField::new('promotion', 'Promotion zuordnen');
    }
    
}
