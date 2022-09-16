<?php

namespace App\Controller\Admin;

use App\Entity\Facture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FactureCrudController extends AbstractCrudController
{
    private $params; 

    public function __construct(ParameterBagInterface $params)
    {
            $this->params = $params;
    }
    public static function getEntityFqcn(): string
    {
        return Facture::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par date de facture
            ->setDefaultSort(['dateFacture' => 'DESC'])
            
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {        
        yield DateTimeField::new('dateFacture', new TranslatableMessage('option.facture_dateFacture', [], 'EasyAdminBundle'));
        yield IdField::new('id', new TranslatableMessage('option.facture_id', [], 'EasyAdminBundle'));
        yield TextField::new('documentPDF', new TranslatableMessage('option.tradNewsletter_documentPDF', [], 'EasyAdminBundle')) 
                ->setTemplatePath('admin/pdf.html.twig')                                             
                ->setCustomOption('base_path', $this->params->get('app.path.facture_documentPDF'))
                ->onlyOnIndex(); 
        
        yield BooleanField::new('statutPaiement', new TranslatableMessage('option.facture_statutPaiement', [], 'EasyAdminBundle'));        
        yield BooleanField::new('statutLivraison', new TranslatableMessage('option.facture_statutLivraison', [], 'EasyAdminBundle'));        
        yield MoneyField::new('montantTotalHorsTva', new TranslatableMessage('option.facture_montantTotalHorsTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield MoneyField::new('montantTotalTva', new TranslatableMessage('option.facture_montantTotalTva', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield MoneyField::new('montantTotal', new TranslatableMessage('option.facture_montantTotal', [], 'EasyAdminBundle'))
                            ->setCurrency('EUR')
                            ->setNumDecimals(2)
                            ->setStoredAsCents(); 
        yield AssociationField::new('utilisateur', new TranslatableMessage('option.facture_utilisateur', [], 'EasyAdminBundle'));
    }    

    // Ajout action "délivrer"    
    public function configureActions(Actions $actions): Actions
    {
        $actionDelivrer = Action::new('Delivrer', new TranslatableMessage('option.facture_delivrer', [], 'EasyAdminBundle'))
            ->displayIf(static function ($entity) {
                // action sera uniquement affiché si le statutLivraison est sur false
                return !$entity->getStatutLivraison();
            })
            ->linkToRoute('livraison', function ($entity): array {
                return [
                    'id' => $entity->getId(),
                ];
            })
            ->displayAsLink();

            
        return $actions
            ->add(Crud::PAGE_INDEX, $actionDelivrer);
    }
}
