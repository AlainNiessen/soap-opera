<?php

namespace App\Controller\Admin;

use App\Entity\TraductionNewsletter;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TraductionNewsletterCrudController extends AbstractCrudController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
            $this->params = $params;
    }

    public static function getEntityFqcn(): string
    {
        return TraductionNewsletter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre', new TranslatableMessage('option.tradNewsletter_nom', [], 'EasyAdminBundle'));
        yield TextField::new('description', new TranslatableMessage('option.tradNewsletter_description', [], 'EasyAdminBundle'));
        yield TextField::new('documentPDF', new TranslatableMessage('option.tradNewsletter_documentPDF', [], 'EasyAdminBundle'))
                //VA AFFICHER DANS LA LISTE SOUS 'PDF' UN LIEN VERS LE PDF
                ->setTemplatePath('admin/pdf.html.twig')
                ->setCustomOption('base_path', $this->params->get('app.path.newsletter_documentPDF'))
                ->onlyOnIndex();        
        yield Field::new('documentFile', new TranslatableMessage('option.tradNewsletter_documentFile', [], 'EasyAdminBundle'))
                ->setFormType(VichImageType::class)                          
                ->setFormTypeOptions(['attr' => ['accept' => 'application/pdf'], 'download_label' => new TranslatableMessage('option.tradNewsletter_download', [], 'EasyAdminBundle')])
                ->onlyOnForms();
        yield AssociationField::new('langue', new TranslatableMessage('option.tradnewsletter_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('newsletter', new TranslatableMessage('option.tradNewsletter_newsletter', [], 'EasyAdminBundle'));
    }    
}
