<?php

namespace App\Controller\Admin;

use App\Entity\Odeur;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OdeurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Odeur::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', new TranslatableMessage('option.odeur_nomBackend', [], 'EasyAdminBundle'));
    }
    
}
