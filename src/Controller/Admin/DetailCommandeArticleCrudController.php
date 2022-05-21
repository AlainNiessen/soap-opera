<?php

namespace App\Controller\Admin;

use App\Entity\DetailCommandeArticle;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield IntegerField::new('quantite', new TranslatableMessage('option.commande_quantite', [], 'EasyAdminBundle'));
        yield MoneyField::new('montantTotalHorsTva', new TranslatableMessage('option.commande_montantTotalHorsTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield MoneyField::new('montantTva', new TranslatableMessage('option.commande_montantTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield MoneyField::new('montantTotal', new TranslatableMessage('option.commande_montantTotal', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield AssociationField::new('article', new TranslatableMessage('option.commande_article', [], 'EasyAdminBundle'));
        yield AssociationField::new('facture', new TranslatableMessage('option.commande_facture', [], 'EasyAdminBundle'));
    }    
}
