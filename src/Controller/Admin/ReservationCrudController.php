<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield DateTimeField::new('dateReservation', new TranslatableMessage('option.reservation_dateReservation', [], 'EasyAdminBundle'));       
        yield MoneyField::new('montantTotalHorsTva', new TranslatableMessage('option.reservation_montantTotalHorsTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents();  
        yield MoneyField::new('montantTva', new TranslatableMessage('option.reservation_montantTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents();  
        yield MoneyField::new('montantTotal', new TranslatableMessage('option.reservation_montantTotal', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents();  
        yield AssociationField::new('event', new TranslatableMessage('option.reservation_event', [], 'EasyAdminBundle'));
        yield AssociationField::new('facture', new TranslatableMessage('option.reservation_facture', [], 'EasyAdminBundle'));
    }
    
}
