<?php

namespace App\Controller\Admin;

use App\Entity\TraductionNewsletter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionNewsletterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionNewsletter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre', 'Name');
        yield TextField::new('description', 'Beschreibung');
        yield AssociationField::new('langue', 'Sprache zuordnen');
        yield AssociationField::new('newsletter', 'Newsletter zuordnen');
    }
    
}
