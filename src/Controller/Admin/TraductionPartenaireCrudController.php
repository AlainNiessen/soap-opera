<?php

namespace App\Controller\Admin;

use App\Entity\TraductionPartenaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionPartenaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionPartenaire::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('description', new TranslatableMessage('option.tradPartenaire_description', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradPartenaire_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('partenaire', new TranslatableMessage('option.tradPartenaire_partenaire', [], 'EasyAdminBundle'));
    }
    
}
