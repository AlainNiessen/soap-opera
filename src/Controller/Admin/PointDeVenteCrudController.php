<?php

namespace App\Controller\Admin;

use App\Entity\PointDeVente;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PointDeVenteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PointDeVente::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
      
        yield TextField::new('nom', new TranslatableMessage('option.pointDeVente_nom', [], 'EasyAdminBundle'));
        yield AssociationField::new('adresse', new TranslatableMessage('option.pointDeVente_adresse', [], 'EasyAdminBundle'));

    }
    
}
