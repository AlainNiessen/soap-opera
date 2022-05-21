<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield TextField::new('nomBackend', new TranslatableMessage('option.event_nomBackend', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateAffichageStart', new TranslatableMessage('option.event_dateAffichageStart', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateAffichageEnd', new TranslatableMessage('option.event_dateAffichageEnd', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateStart', new TranslatableMessage('option.event_dateStart', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateEnd', new TranslatableMessage('option.event_dateEnd', [], 'EasyAdminBundle'));
        yield MoneyField::new('montantHorsTva', new TranslatableMessage('option.event_montantHorsTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield PercentField::new('tauxTva', new TranslatableMessage('option.event_tauxTva', [], 'EasyAdminBundle'))
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true); 
        yield IntegerField::new('nombreLimit', new TranslatableMessage('option.event_nombreLimit', [], 'EasyAdminBundle'));        
        yield AssociationField::new('typeEvent', new TranslatableMessage('option.event_typeEvent', [], 'EasyAdminBundle'));
        
    }
    
}
