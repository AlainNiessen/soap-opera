<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomBackend', 'Name für Adminbereich');
        yield DateTimeField::new('dateAffichageStart', 'Start Anzeige Veranstaltung');
        yield DateTimeField::new('dateAffichageEnd', 'Ende Anzeige Veranstaltung');
        yield DateTimeField::new('dateStart', 'Start Veranstaltung');
        yield DateTimeField::new('dateEnd', 'Ende Veranstaltung');
        yield MoneyField::new('montantHorsTva', 'Betrag ohne MwSt')->setCurrency('EUR')->setNumDecimals(2); 
        yield PercentField::new('tauxTva', 'MwSt'); 
        yield IntegerField::new('nombreLimit', 'Maximale Teilnehmeranzahl');
        yield TextField::new('documentPDF', 'PDF')
                            //will display under PDF a link to the pdf-file
                            ->setTemplatePath('admin/pdf.html.twig')
                            ->setCustomOption('base_path', $this->params->get('app.path.newsletter_documentPDF'));
        yield Field::new('documentFile')
                            ->setFormType(VichImageType::class)                
                            ->setLabel('PDF hinzufügen')
                            ->setFormTypeOptions(['attr' => ['accept' => 'application/pdf']])
                            ->onlyOnForms();  
        yield AssociationField::new('typeEvent', 'Veranstaltungstyp zuordnen');
        
    }
    
}
