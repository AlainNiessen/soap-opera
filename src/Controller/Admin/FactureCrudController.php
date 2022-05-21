<?php

namespace App\Controller\Admin;

use App\Entity\Facture;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield DateTimeField::new('dateFacture', new TranslatableMessage('option.facture_dateFacture', [], 'EasyAdminBundle'));
        yield BooleanField::new('statutPaiement', new TranslatableMessage('option.facture_statutPaiement', [], 'EasyAdminBundle'));        
        yield MoneyField::new('montantTotalHorsTva', new TranslatableMessage('option.facture_montantTotalHorsTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield MoneyField::new('montantTotalTva', new TranslatableMessage('option.facture_montantTotalTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield MoneyField::new('montantTotal', new TranslatableMessage('option.facture_montantTotal', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield AssociationField::new('utilisateur', new TranslatableMessage('option.facture_utilisateur', [], 'EasyAdminBundle'));
    }    
}
