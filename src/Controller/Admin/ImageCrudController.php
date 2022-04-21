<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield Field::new('imageFile')
                ->setFormType(VichImageType::class)                
                ->setLabel('Foto hinzufügen');
        yield BooleanField::new('layoutWebsite', 'Handelt es sich um ein Foto für das Layout der Webseite?');
        yield AssociationField::new('positionImage', 'Position auf Webseite definieren');
        yield AssociationField::new('categorie', 'Kategorie zuordnen');
        yield AssociationField::new('article', 'Artikel zuordnen');
        yield AssociationField::new('partenaire', 'Partner zuordnen');
        yield AssociationField::new('event', 'Veranstaltung zuordnen');
        
    }
    
}
