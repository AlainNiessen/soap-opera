<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // rangé par date de facture
            ->setDefaultSort(['dateCommentaire' => 'DESC'])
            
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('contenu', new TranslatableMessage('option.commentaire_contenu', [], 'EasyAdminBundle'));
        yield DateTimeField::new('dateCommentaire', new TranslatableMessage('option.commentaire_dateCommentaire', [], 'EasyAdminBundle'));
        yield BooleanField::new('publication', new TranslatableMessage('option.commentaire_publication', [], 'EasyAdminBundle'));
        yield AssociationField::new('article', new TranslatableMessage('option.commentaire_article', [], 'EasyAdminBundle') );
        yield AssociationField::new('utilisateur', new TranslatableMessage('option.commentaire_utilisateur', [], 'EasyAdminBundle'));
    }

    // Ajout action "publier"    
    public function configureActions(Actions $actions): Actions
    {
        $actionPublier = Action::new('Publier', new TranslatableMessage('option.commentaire_publier', [], 'EasyAdminBundle'))
            ->displayIf(static function ($entity) {
                // action sera uniquement affiché si le statutPublication est sur false
                return !$entity->getPublication();
            })
            ->linkToRoute('publier', function ($entity): array {
                return [
                    'id' => $entity->getId(),
                ];
            })
            ->displayAsLink();

            
        return $actions
            // ...
            ->add(Crud::PAGE_INDEX, $actionPublier);
    }
    
}
