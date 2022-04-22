<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EventCrudController extends AbstractCrudController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
             $this->params = $params;
     }

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
        yield MoneyField::new('montantHorsTva', 'Betrag ohne MwSt')
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield PercentField::new('tauxTva', 'MwSt')
                            ->setNumDecimals(2)
                            ->setStoredAsFractional(true); 
        yield IntegerField::new('nombreLimit', 'Maximale Teilnehmeranzahl');
        yield TextField::new('documentPDF', 'PDF')
                            //VA AFFICHER DANS LA LISTE SOUS 'PDF' UN LIEN VERS LE PDF
                            ->setTemplatePath('admin/pdf.html.twig')
                            ->setCustomOption('base_path', $this->params->get('app.path.newsletter_documentPDF'));
        yield Field::new('documentFile')
                            ->setFormType(VichImageType::class)                
                            ->setLabel('PDF hinzufügen')
                            ->setFormTypeOptions(['attr' => ['accept' => 'application/pdf'], 'download_label' => 'PDF einsehen'])
                            ->onlyOnForms();  
        yield AssociationField::new('typeEvent', 'Veranstaltungstyp zuordnen');
        
    }
    
}
