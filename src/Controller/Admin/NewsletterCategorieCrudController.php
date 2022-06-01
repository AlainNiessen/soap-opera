<?php

namespace App\Controller\Admin;

use App\Entity\NewsletterCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NewsletterCategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewsletterCategorie::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', new TranslatableMessage('option.newsletter_nomBackend', [], 'EasyAdminBundle'));  
    }    
}
