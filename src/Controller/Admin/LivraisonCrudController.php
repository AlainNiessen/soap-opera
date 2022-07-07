<?php

namespace App\Controller\Admin;

use App\Entity\Livraison;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LivraisonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livraison::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // limiter les pays à Belgique et Allemange
        $supportedCountries = ['BE', 'DE'];
        yield MoneyField::new('prix', new TranslatableMessage('option.livraison_prix', [], 'EasyAdminBundle'))
                        ->setCurrency('EUR')
                        ->setNumDecimals(2)
                        ->setStoredAsCents(); 
        yield CountryField::new('pays', new TranslatableMessage('option.livraison_pays', [], 'EasyAdminBundle'))
                        ->setFormType(CountryType::class)
                        ->setFormTypeOptions(['choice_filter' => function ($countryName) use ($supportedCountries) {
                            return in_array($countryName, $supportedCountries, true);
                        }]);  
        
    }
    
}
