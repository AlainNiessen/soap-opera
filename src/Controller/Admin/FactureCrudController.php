<?php

namespace App\Controller\Admin;

use App\Entity\Facture;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FactureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Facture::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('dateFacture', 'Datum Rechnung');
        yield BooleanField::new('statutPaiement', 'Bezahlt?');        
        yield MoneyField::new('montantTotalHorsTva', 'Gesamtbetrag ohne MwSt')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2);
        yield MoneyField::new('montantTotalTva', 'Gesamtbetrag MwSt')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2);
        yield MoneyField::new('montantTotal', 'Gesamtbetrag')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2);
        yield AssociationField::new('utilisateur', 'Nutzer zuordnen');
    }    
}
