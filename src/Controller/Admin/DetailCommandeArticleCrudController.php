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
        yield IntegerField::new('quantite');
        yield MoneyField::new('montantTotalHorsTva')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield MoneyField::new('montantTva')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield MoneyField::new('montantTotal')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield AssociationField::new('article');
        yield AssociationField::new('facture');
    }    
}
