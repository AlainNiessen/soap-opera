<?php

namespace App\Controller\Admin;


use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

       
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', new TranslatableMessage('option.article_nomBackend', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateCreation', new TranslatableMessage('option.article_dateCreation', [], 'EasyAdminBundle'));
        yield MoneyField::new('montantHorsTva', new TranslatableMessage('option.article_montantHorsTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents();        
        yield PercentField::new('tauxTva', new TranslatableMessage('option.article_tauxTva', [], 'EasyAdminBundle'))
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true);        
        yield BooleanField::new('enAvant', new TranslatableMessage('option.article_enAvant', [], 'EasyAdminBundle'));
        yield IntegerField::new('nombreVentes', new TranslatableMessage('option.article_nombreVentes', [], 'EasyAdminBundle'));  
        yield AssociationField::new('categorie', new TranslatableMessage('option.article_categorie', [], 'EasyAdminBundle'));
        yield AssociationField::new('odeur', new TranslatableMessage('option.article_odeur', [], 'EasyAdminBundle'));
        yield AssociationField::new('beurre', new TranslatableMessage('option.article_beurre', [], 'EasyAdminBundle'));
        yield AssociationField::new('huile', new TranslatableMessage('option.article_huile', [], 'EasyAdminBundle'));
        yield AssociationField::new('huileEssentiell', new TranslatableMessage('option.article_huileEss', [], 'EasyAdminBundle'));
        yield AssociationField::new('ingredientSupplementaire', new TranslatableMessage('option.articleIng', [], 'EasyAdminBundle'));
        yield AssociationField::new('promotion', new TranslatableMessage('option.article_promotion', [], 'EasyAdminBundle'));
    }   
}
