<?php

namespace App\Controller\Admin;

use App\Entity\TraductionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
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
        yield TextField::new('titre', new TranslatableMessage('option.tradEvent_titre', [], 'EasyAdminBundle'));
        yield TextField::new('description', new TranslatableMessage('option.tradEvent_description', [], 'EasyAdminBundle'));
        yield TextField::new('documentPDF', new TranslatableMessage('option.tradEvent_documentPDF', [], 'EasyAdminBundle'))
                            //VA AFFICHER DANS LA LISTE SOUS 'PDF' UN LIEN VERS LE PDF
                            ->setTemplatePath('admin/pdf.html.twig')
                            ->setCustomOption('base_path', $this->params->get('app.path.event_documentPDF'))
                            ->onlyOnIndex();
        yield Field::new('documentFile', new TranslatableMessage('option.tradEvent_documentFile', [], 'EasyAdminBundle'))
                            ->setFormType(VichImageType::class)                
                            ->setFormTypeOptions(['attr' => ['accept' => 'application/pdf'], 'download_label' => new TranslatableMessage('option.tradEvent_downloadPDF', [], 'EasyAdminBundle')])
                            ->onlyOnForms();  
        yield AssociationField::new('langue', new TranslatableMessage('option.tradEvent_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('event', new TranslatableMessage('option.tradEvent_event', [], 'EasyAdminBundle'));
    }    
}
