<?php

namespace App\Controller\Admin;

use App\Entity\TraductionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionEventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionEvent::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
