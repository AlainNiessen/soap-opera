<?php

namespace App\Controller\Admin;

use App\Entity\PositionImage;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PositionImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PositionImage::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('position', new TranslatableMessage('option.positionImage_position', [], 'EasyAdminBundle'));
    }
    
}
