<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('dateReservation', 'Datum Reservierung');       
        yield MoneyField::new('montantTotalHorsTva', 'Gesamtbetrag ohne MwSt')->setCurrency('EUR')->setNumDecimals(2);
        yield MoneyField::new('montantTva', 'Betrag MwSt')->setCurrency('EUR')->setNumDecimals(2);
        yield MoneyField::new('montantTotal', 'Gesamtbetrag')->setCurrency('EUR')->setNumDecimals(2);
    }
    
}
