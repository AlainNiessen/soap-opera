<?php

namespace App\Controller\Admin;

use App\Entity\Beurre;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BeurreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Beurre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend');
    }
    
}
