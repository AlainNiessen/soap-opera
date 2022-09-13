<?php

namespace App\Controller\Admin;

use App\Entity\Huile;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HuileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Huile::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', new TranslatableMessage('option.huile_nomBackend', [], 'EasyAdminBundle'));
    }
    
}
