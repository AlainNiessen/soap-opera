<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class EventCrudController extends AbstractCrudController
{
    

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend');
        yield DateTimeField::new('dateAffichageStart');
        yield DateTimeField::new('dateAffichageEnd');
        yield DateTimeField::new('dateStart');
        yield DateTimeField::new('dateEnd');
        yield MoneyField::new('montantHorsTva')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield PercentField::new('tauxTva')
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true); 
        yield IntegerField::new('nombreLimit');        
        yield AssociationField::new('typeEvent');
        
    }
    
}
