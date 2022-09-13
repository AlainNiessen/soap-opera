<?php

namespace App\Controller\Admin;

use App\Entity\Evaluation;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EvaluationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evaluation::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('article', new TranslatableMessage('option.evaluation_article', [], 'EasyAdminBundle') );
        yield IntegerField::new('nombreEtoiles', new TranslatableMessage('option.evaluation_nr_etoiles', [], 'EasyAdminBundle') );
        yield AssociationField::new('utilisateur', new TranslatableMessage('option.evaluation_utilisateur', [], 'EasyAdminBundle'));
    }
    
}
