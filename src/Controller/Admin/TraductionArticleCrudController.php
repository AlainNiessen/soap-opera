<?php

namespace App\Controller\Admin;

use App\Entity\TraductionArticle;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionArticle::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['article' => 'DESC'])
            
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('article', new TranslatableMessage('option.tradArticle_article', [], 'EasyAdminBundle'));
        yield TextField::new('nom', new TranslatableMessage('option.tradArticle_nom', [], 'EasyAdminBundle'));
        yield TextEditorField::new('description', new TranslatableMessage('option.tradArticle_description', [], 'EasyAdminBundle'));
        yield TextField::new('slogan', new TranslatableMessage('option.tradArticle_slogan', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradArticle_langue', [], 'EasyAdminBundle'));
        
    }
    
}
