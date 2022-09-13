<?php

namespace App\Controller\Admin;

use App\Entity\Langue;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LangueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Langue::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('langue', new TranslatableMessage('option.langue_langue', [], 'EasyAdminBundle'));
        yield TextField::new('codeLangue', new TranslatableMessage('option.langue_codeLangue', [], 'EasyAdminBundle'));
    }
    
}
