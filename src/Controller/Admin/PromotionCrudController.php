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
        yield TextField::new('nomBackend');
        yield DateTimeField::new('dateAffichageStart');
        yield DateTimeField::new('dateAffichageEnd');
        yield DateTimeField::new('dateStart');
        yield DateTimeField::new('dateEnd');
        yield PercentField::new('Pourcentage')
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true);
        yield AssociationField::new('article');
        yield AssociationField::new('categorie');
    }
    
}
