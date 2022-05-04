<?php

namespace App\Controller\Admin;

use App\Entity\TraductionArticle;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionArticle::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom', 'Name');
        yield TextEditorField::new('description', 'Beschreibung');
        yield TextField::new('slogan', 'Slogan');
        yield AssociationField::new('langue', 'Sprache zuordnen');
        yield AssociationField::new('article', 'Artikel zuordnen');
    }
    
}
