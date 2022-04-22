<?php

namespace App\Controller\Admin;

use App\Entity\DetailCommandeArticle;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DetailCommandeArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DetailCommandeArticle::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('quantite', 'Anzahl Artikel');
        yield MoneyField::new('montantTotalHorsTva', 'Gesamtbetrag ohne MwSt')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2);
        yield MoneyField::new('montantTva', 'Gesamtbetrag MwSt')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2);
        yield MoneyField::new('montantTotal', 'Gesamtbetrag')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2);
        yield AssociationField::new('article', 'Artikel zuordnen');
        yield AssociationField::new('facture', 'Rechnung zuordnen');
    }    
}
