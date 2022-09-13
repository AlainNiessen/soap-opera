<?php

namespace App\Controller\Admin;

use App\Entity\HuileEssentiel;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HuileEssentielCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HuileEssentiel::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', new TranslatableMessage('option.huileEss_nomBackend', [], 'EasyAdminBundle'));
    }
    
}
