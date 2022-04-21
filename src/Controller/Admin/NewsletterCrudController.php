<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class NewsletterCrudController extends AbstractCrudController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
   {
            $this->params = $params;
    }

    public static function getEntityFqcn(): string
    {
        return Newsletter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', 'Name für Adminbereich');
        yield TextField::new('documentPDF', 'PDF')
                //will display under PDF a link to the pdf-file
                ->setTemplatePath('admin/pdf.html.twig')
                ->setCustomOption('base_path', $this->params->get('app.path.newsletter_documentPDF'))
                ->onlyOnIndex();
        yield DateTimeField::new('dateNewsletter', 'Datum');
        yield Field::new('documentFile')
                ->setFormType(VichImageType::class)                
                ->setLabel('PDF')              
                ->setFormTypeOptions(['attr' => ['accept' => 'application/pdf']]);               
    }    
}
