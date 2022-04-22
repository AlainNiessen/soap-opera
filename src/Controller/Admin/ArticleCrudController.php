<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
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
        yield TextField::new('nomBackend', 'Name für Adminbereich');
        yield MoneyField::new('montantHorsTva', 'Betrag ohne MwSt')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents();        
        yield PercentField::new('tauxTva', 'MwSt')
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(false);;
        yield BooleanField::new('enAvant', 'Wird angezeigt?');
        yield IntegerField::new('nombreVentes', 'Anzahl Verkäufe');  
        yield AssociationField::new('categorie', 'Kategorie zuordnen');
        yield AssociationField::new('odeur', 'Duft zuordnen');
        yield AssociationField::new('beurre', 'Butter zuordnen');
        yield AssociationField::new('huile', 'Öl zuordnen');
        yield AssociationField::new('huileEssentiell', 'Ätherisches Öl zuordnen');
        yield AssociationField::new('ingredientSupplementaire', 'Zusatz zuordnen');
    }   
}
