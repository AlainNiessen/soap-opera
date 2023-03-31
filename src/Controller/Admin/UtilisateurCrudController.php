<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield EmailField::new('email', new TranslatableMessage('option.utilisateur_email', [], 'EasyAdminBundle'));
        yield ArrayField::new('roles', new TranslatableMessage('option.utilisateur_roles', [], 'EasyAdminBundle'));
        yield TextField::new('plainPassword', new TranslatableMessage('option.utilisateur_plainPassword', [], 'EasyAdminBundle'))
                        ->onlyOnForms();
        yield TextField::new('nomEntreprise', new TranslatableMessage('option.utilisateur_nomEntreprise', [], 'EasyAdminBundle'));
        yield TextField::new('numeroTVA', new TranslatableMessage('option.utilisateur_numeroTVA', [], 'EasyAdminBundle'));
        yield TextField::new('nom', new TranslatableMessage('option.utilisateur_nom', [], 'EasyAdminBundle'));
        yield TextField::new('prenom', new TranslatableMessage('option.utilisateur_prenom', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateNaissance', new TranslatableMessage('option.utilisateur_dateNaissance', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateInscription', new TranslatableMessage('option.utilisateur_dateInscription', [], 'EasyAdminBundle'))
                             ->onlyOnIndex();
        yield BooleanField::new('inscriptionValide', new TranslatableMessage('option.utilisateur_inscriptionValide', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.utilisateur_langue', [], 'EasyAdminBundle'));                      
        yield AssociationField::new('adresseHome', new TranslatableMessage('option.utilisateur_adresseHome', [], 'EasyAdminBundle'));                      
        yield AssociationField::new('adresseDeliver', new TranslatableMessage('option.utilisateur_adresseDeliver', [], 'EasyAdminBundle'));
        yield BooleanField::new('ramassage', new TranslatableMessage('option.utilisateur_ramassage', [], 'EasyAdminBundle'));                      
    }    
}
