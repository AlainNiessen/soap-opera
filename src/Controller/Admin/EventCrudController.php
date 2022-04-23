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
        yield TextField::new('nomBackend', 'Name für Adminbereich');
        yield DateTimeField::new('dateAffichageStart', 'Start Anzeige Veranstaltung');
        yield DateTimeField::new('dateAffichageEnd', 'Ende Anzeige Veranstaltung');
        yield DateTimeField::new('dateStart', 'Start Veranstaltung');
        yield DateTimeField::new('dateEnd', 'Ende Veranstaltung');
        yield MoneyField::new('montantHorsTva', 'Betrag ohne MwSt')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield PercentField::new('tauxTva', 'MwSt')
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true); 
        yield IntegerField::new('nombreLimit', 'Maximale Teilnehmeranzahl');        
        yield AssociationField::new('typeEvent', 'Veranstaltungstyp zuordnen');
        
    }
    
}
