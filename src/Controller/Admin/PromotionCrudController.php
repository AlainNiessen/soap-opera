<?php

namespace App\Controller\Admin;

use App\Entity\Promotion;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield TextField::new('nomBackend', new TranslatableMessage('option.promotion_nomBackend', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateAffichageStart', new TranslatableMessage('option.promotion_dateAffichageStart', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateAffichageEnd', new TranslatableMessage('option.promotion_dateAffichageEnd', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateStart', new TranslatableMessage('option.promotion_dateStart', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateEnd', new TranslatableMessage('option.promotion_dateEnd', [], 'EasyAdminBundle'));
        yield PercentField::new('Pourcentage', new TranslatableMessage('option.promotion_pourcentage', [], 'EasyAdminBundle'))
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true);  
    }
    
}
