<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield TextField::new('nomBackend', new TranslatableMessage('option.newsletter_nomBackend', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateNewsletter', new TranslatableMessage('option.newsletter_dateNewsletter', [], 'EasyAdminBundle'));                          
    }    
}
