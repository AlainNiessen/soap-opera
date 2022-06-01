<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
        yield DateTimeField::new('dateNewsletter', new TranslatableMessage('option.newsletter_dateNewsletter', [], 'EasyAdminBundle'))
                            ->onlyOnIndex();
        yield BooleanField::new('statutEnvoie', new TranslatableMessage('option.newsletter_statutEnvoie', [], 'EasyAdminBundle'))
                            ->onlyOnIndex();
        yield AssociationField::new('newsletterCategories', new TranslatableMessage('option.newsletter_newsletterCategorie', [], 'EasyAdminBundle'));                          
    }    
}
