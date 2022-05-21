<?php

namespace App\Controller\Admin;

use App\Entity\TraductionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TraductionEventCrudController extends AbstractCrudController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
             $this->params = $params;
    }

    public static function getEntityFqcn(): string
    {
        return TraductionEvent::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre');
        yield TextField::new('description');
        yield TextField::new('documentPDF')
                            //VA AFFICHER DANS LA LISTE SOUS 'PDF' UN LIEN VERS LE PDF
                            ->setTemplatePath('admin/pdf.html.twig')
                            ->setCustomOption('base_path', $this->params->get('app.path.event_documentPDF'))
                            ->onlyOnIndex();
        yield Field::new('documentFile')
                            ->setFormType(VichImageType::class)                
                            ->setFormTypeOptions(['attr' => ['accept' => 'application/pdf'], 'download_label' => 'PDF einsehen'])
                            ->onlyOnForms();  
        yield AssociationField::new('langue');
        yield AssociationField::new('event');
    }    
}
