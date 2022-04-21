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
        yield EmailField::new('email', 'E-Mail');
        yield ArrayField::new('roles', 'Rolle');
        yield TextField::new('password', 'Passwort');
        yield TextField::new('nom', 'Name');
        yield TextField::new('prenom', 'Vorname');
        yield DateTimeField::new('dateNaissance', 'Geburtsdatum');
        yield DateTimeField::new('dateInscription', 'Einschreibedatum');
        yield BooleanField::new('inscriptionValide', 'Einschreibebestätigung');
        yield AssociationField::new('langue', 'Sprache zuordnen');                      
        yield AssociationField::new('adresseHome', 'Wohnadresse zuordnen');                      
        yield AssociationField::new('adresseDeliver', 'Lieferadresse zuordnen');                      
    }    
}
