<?php

namespace App\Controller\Admin;

use App\Entity\Philosophie;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PhilosophieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Philosophie::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextEditorField::new('philosophie', new TranslatableMessage('option.philosophie_philosophie', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.philosophie_langue', [], 'EasyAdminBundle'));
    }
    
}
