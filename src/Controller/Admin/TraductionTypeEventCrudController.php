<?php

namespace App\Controller\Admin;

use App\Entity\TraductionTypeEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraductionTypeEventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TraductionTypeEvent::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom', new TranslatableMessage('option.tradTypeEvent_nom', [], 'EasyAdminBundle'));
        yield AssociationField::new('langue', new TranslatableMessage('option.tradTypeEvent_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('typeEvent', new TranslatableMessage('option.tradtypeEvent_typeEvent', [], 'EasyAdminBundle'));
    }
    
}
