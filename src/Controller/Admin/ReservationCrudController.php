<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('dateReservation');       
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
        yield AssociationField::new('event');
        yield AssociationField::new('facture');
    }
    
}
