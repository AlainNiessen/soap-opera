<?php

namespace App\Controller\Admin;

use App\Entity\TraductionNewsletter;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
        yield TextField::new('titre', 'Name');
        yield TextField::new('description', 'Beschreibung');
        yield TextField::new('documentPDF', 'PDF')
                //VA AFFICHER DANS LA LISTE SOUS 'PDF' UN LIEN VERS LE PDF
                ->setTemplatePath('admin/pdf.html.twig')
                ->setCustomOption('base_path', $this->params->get('app.path.newsletter_documentPDF'))
                ->onlyOnIndex();        
        yield Field::new('documentFile', 'PDF')
                ->setFormType(VichImageType::class)                          
                ->setFormTypeOptions(['attr' => ['accept' => 'application/pdf'], 'download_label' => 'Ouvrir le fichier'])
                ->onlyOnForms();
        yield AssociationField::new('langue', 'Sprache zuordnen');
        yield AssociationField::new('newsletter', 'Newsletter zuordnen');
    }    
}
