<?php

namespace App\Controller\Admin;

use App\Entity\Promotion;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PromotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Promotion::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', 'Name für Adminbereich');
        yield DateTimeField::new('dateAffichageStart', 'Start Anzeige Promotion');
        yield DateTimeField::new('dateAffichageEnd', 'Ende Anzeige Promotion');
        yield DateTimeField::new('dateStart', 'Start Promotion');
        yield DateTimeField::new('dateEnd', 'Ende Promotion');
        yield PercentField::new('Pourcentage', 'Prozentsatz')
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true);
        yield AssociationField::new('article', 'Artikel zuordnen');
        yield AssociationField::new('categorie', 'Kategorie zuordnen');
    }
    
}
