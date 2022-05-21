<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email');
        yield ArrayField::new('roles');
        yield TextField::new('plainPassword')
                        ->onlyOnForms();;
        yield TextField::new('nom');
        yield TextField::new('prenom');
        yield DateTimeField::new('dateNaissance');
        yield DateTimeField::new('dateInscription');
        yield BooleanField::new('inscriptionValide');
        yield AssociationField::new('langue');                      
        yield AssociationField::new('adresseHome');                      
        yield AssociationField::new('adresseDeliver');                      
    }    
}
