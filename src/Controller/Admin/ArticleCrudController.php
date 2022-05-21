<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
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
        yield TextField::new('nomBackend');
        yield DateTimeField::new('dateCreation');
        yield MoneyField::new('montantHorsTva')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents();        
        yield PercentField::new('tauxTva')
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true);        
        yield BooleanField::new('enAvant');
        yield IntegerField::new('nombreVentes');  
        yield AssociationField::new('categorie');
        yield AssociationField::new('odeur');
        yield AssociationField::new('beurre');
        yield AssociationField::new('huile');
        yield AssociationField::new('huileEssentiell');
        yield AssociationField::new('ingredientSupplementaire');
    }   
}
