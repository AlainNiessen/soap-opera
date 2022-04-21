<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
        $imageField = Field::new('imageFile')
                            ->setFormType(VichImageType::class)                
                            ->setLabel('Foto hinzufügen')
                            ->setFormTypeOptions(['attr' => ['accept' => 'image/*']]);

        $image = ImageField::new('nom')
                            ->setBasePath('/uploads/images')              
                            ->setLabel('Foto');

        
        $fields = [                
            BooleanField::new('layoutWebsite', 'Handelt es sich um ein Foto für das Layout der Webseite?'),
            AssociationField::new('positionImage', 'Position auf Webseite definieren'),
            AssociationField::new('categorie', 'Kategorie zuordnen'),
            AssociationField::new('article', 'Artikel zuordnen'),
            AssociationField::new('partenaire', 'Partner zuordnen'),
            AssociationField::new('event', 'Veranstaltung zuordnen'),
        ];
        
        // if page = index or detail => display image    
        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            array_unshift($fields, $image);           
        } else {
            array_unshift($fields, $imageField);
        }

        return $fields;        
    }    
}
