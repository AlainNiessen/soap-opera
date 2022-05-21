<?php

namespace App\Controller\Admin;

use App\Entity\TypeEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypeEventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeEvent::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', new TranslatableMessage('option.typeEvent_nomBackend', [], 'EasyAdminBundle'));
    }
    
}
