<?php

namespace App\Controller\Admin;

use App\Entity\TraductionNewsletter;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par facture
            ->setDefaultSort(['newsletter' => 'DESC'])
            
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {   
          
        yield TextField::new('titre', new TranslatableMessage('option.tradNewsletter_nom', [], 'EasyAdminBundle'));
        yield TextEditorField::new('description', new TranslatableMessage('option.tradNewsletter_description', [], 'EasyAdminBundle'));
        // possibilité de télécharger le PDF sur la page index           
        yield TextField::new('documentPDF', new TranslatableMessage('option.tradNewsletter_documentPDF', [], 'EasyAdminBundle'))                           
                ->setTemplatePath('admin/pdf.html.twig')                    
                ->setCustomOption('base_path', $this->params->get('app.path.newsletter_documentPDF'))
                ->onlyOnIndex(); 
        // possibilité d'ajouter un PDF        
        yield Field::new('documentFile', new TranslatableMessage('option.tradNewsletter_documentFile', [], 'EasyAdminBundle'))
                ->setFormType(VichFileType::class)                          
                ->setFormTypeOptions(['attr' => ['accept' => 'application/pdf'], 'download_label' => 'Download PDF'])
                ->onlyOnForms();
        yield AssociationField::new('langue', new TranslatableMessage('option.tradnewsletter_langue', [], 'EasyAdminBundle'));
        yield AssociationField::new('newsletter', new TranslatableMessage('option.tradNewsletter_newsletter', [], 'EasyAdminBundle'));
    }     
}
