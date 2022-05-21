<?php

namespace App\Controller\Admin;

use App\Entity\TraductionHuileEssentiel;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionHuileEssentielCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionHuileEssentiel::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom');
        yield AssociationField::new('langue');
        yield AssociationField::new('huileEssentiel');
    }
    
}
