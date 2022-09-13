<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Translation\TranslatableMessage;
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
        // configuration pour ajouter une image
        $imageField = Field::new('imageFile', new TranslatableMessage('option.image_ajout', [], 'EasyAdminBundle'))
                            ->setFormType(VichImageType::class)                
                            ->setFormTypeOptions(['attr' => ['accept' => 'image/*']]);

        // configuration pour enregistrer le nom de l'image dans un répertoire /uploads/images
        $image = ImageField::new('nom', new TranslatableMessage('option.image_nom', [], 'EasyAdminBundle'))
                            ->setBasePath('/uploads/images');        
        $fields = [                            
            AssociationField::new('positionImage', new TranslatableMessage('option.image_positionImage', [], 'EasyAdminBundle')),
            AssociationField::new('categorie', new TranslatableMessage('option.image_categorie', [], 'EasyAdminBundle')),
            AssociationField::new('pointDeVente', new TranslatableMessage('option.image_pointDeVente', [], 'EasyAdminBundle')),
            AssociationField::new('article', new TranslatableMessage('option.image_article', [], 'EasyAdminBundle')),
            BooleanField::new('coverListArticle', new TranslatableMessage('option.image_coverListArticle', [], 'EasyAdminBundle')),
            BooleanField::new('coverDetailArticle', new TranslatableMessage('option.image_coverDetailArticle', [], 'EasyAdminBundle')),
            
        ];
        
        // affichage de l'image dépendant de la page (index ou detail)    
        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            array_unshift($fields, $image);  
        // sinon ajout de l'image         
        } else {
            array_unshift($fields, $imageField);
        }

        return $fields;        
    }    
}
