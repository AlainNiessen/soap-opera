<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom', 'Name');
        yield BooleanField::new('layoutWebsite', 'Handelt es sich um ein Foto für das Layout der Webseite?');
    }
    
}
