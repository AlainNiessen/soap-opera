<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('contenu', 'Kommentar');
        yield DateTimeField::new('dateCommentaire', 'Datum');
        yield BooleanField::new('commentaireInfructueux', 'Freischaltung');
        yield IntegerField::new('nombreEtoiles', 'Anzahl Sterne');

    }
    
}
