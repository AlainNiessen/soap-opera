<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NewsletterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Newsletter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('dateNewsletter', 'Datum');
        yield ImageField::new('documentPDF', 'PDF hinzufügen')->setFormTypeOptions(['attr' => ['accept' => 'application/pdf']]);
    }
    
}
