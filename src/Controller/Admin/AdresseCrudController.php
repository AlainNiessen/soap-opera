<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdresseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adresse::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        // limiter les pays à Belgique et Allemange
        $supportedCountries = ['BE', 'DE'];
        yield TextField::new('rue', new TranslatableMessage('option.adresse_rue', [], 'EasyAdminBundle'));
        yield TextField::new('numeroRue', new TranslatableMessage('option.adresse_numero_rue', [], 'EasyAdminBundle'));        
        yield TextField::new('codePostal', new TranslatableMessage('option.adresse_code_postal', [], 'EasyAdminBundle'));
        yield TextField::new('ville', new TranslatableMessage('option.adresse_ville', [], 'EasyAdminBundle'));
        yield CountryField::new('pays', new TranslatableMessage('option.adresse_pays', [], 'EasyAdminBundle'))
                    ->setFormType(CountryType::class)
                    ->setFormTypeOptions(['choice_filter' => function ($countryName) use ($supportedCountries) {
                        return in_array($countryName, $supportedCountries, true);
                    }]);        
    }
}
