<?php

namespace App\Controller\Admin;

use App\Entity\TraductionNewsletter;
use Doctrine\ORM\EntityManagerInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Repository\TraductionNewsletterRepository;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TraductionNewsletterCrudController extends AbstractCrudController
{
    private $params;
    private $entityManager; 

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $entityManager)
    {
            $this->params = $params;
            $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return TraductionNewsletter::class;
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
