<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Huile;
use App\Entity\Image;
use App\Entity\Odeur;
use App\Entity\Beurre;
use App\Entity\Langue;
use App\Entity\Adresse;
use App\Entity\Article;
use App\Entity\Facture;
use App\Entity\Categorie;
use App\Entity\Livraison;
use App\Entity\Promotion;
use App\Entity\TypeEvent;
use App\Entity\Evaluation;
use App\Entity\Newsletter;
use App\Entity\Partenaire;
use App\Entity\Commentaire;
use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\PositionImage;
use App\Entity\HuileEssentiel;
use App\Entity\TraductionEvent;
use App\Entity\TraductionHuile;
use App\Entity\TraductionOdeur;
use App\Entity\TraductionBeurre;
use App\Entity\TraductionArticle;
use App\Entity\NewsletterCategorie;
use App\Entity\TraductionCategorie;
use App\Entity\TraductionPromotion;
use App\Entity\TraductionTypeEvent;
use App\Entity\TraductionNewsletter;
use App\Entity\TraductionPartenaire;
use App\Entity\DetailCommandeArticle;
use App\Entity\IngredientSupplementaire;
use App\Entity\TraductionHuileEssentiel;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TraductionNewsletterCategorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TraductionIngredientSupplementaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{  
    /**
     * @Route("/admin_s_op", name="admin_s_op")
     */
    public function interface(Request $request, EntityManagerInterface $entityManager): Response
    {
        //récupération langue
        $lang = $request-> getLocale();
        
        // récupération des informations pour les statistiques générales
        // définition repository utilisateur
        $repositoryUtilisateur = $entityManager -> getRepository(Utilisateur::class);
        // fonction de requête sur base de données récupérées 
        $nombreUtilisateurs = $repositoryUtilisateur -> countUtilisateurs();
        // définition repository utilisateur
        $repositoryArticles = $entityManager -> getRepository(Article::class);
        // fonction de requête sur base de données récupérées 
        $nombreArticles = $repositoryArticles -> countArticles();

        // récupération de toutes les catégories de Newsletter
        // définition repository evaluation
        $repositoryCategorieNewsletter = $entityManager -> getRepository(NewsletterCategorie::class);
        $repositoryTraductionCategorieNewsletter = $entityManager -> getRepository(TraductionNewsletterCategorie::class);
        // fonction de requête sur base de données récupérées 
        $categoriesNewsletter = $repositoryCategorieNewsletter -> findAll();
        
        $tabNombreUtilisateurs = [];
        $tabNomsCategorieNewsletter = [];
        $tabColorCategorieNewsletter = [];
        foreach($categoriesNewsletter as $categorieNewsletter):
            $utilisateurs = $categorieNewsletter -> getUtilisateurs();
            $couleurCategorieNewsletter = $categorieNewsletter -> getColor();
            $nombreUtilisateursCategorieNewsletter = count($utilisateurs);            
            $traductionNewsletter = $repositoryTraductionCategorieNewsletter -> findTraduction($categorieNewsletter, $lang);            
            $tabNomsCategorieNewsletter[] = $traductionNewsletter->getNom();
            $tabNombreUtilisateurs[] = $nombreUtilisateursCategorieNewsletter;
            $tabColorCategorieNewsletter[] = $couleurCategorieNewsletter;
        endforeach;
       
        // si il s'agit d'une requête AJAX
        // re-rendering le contenu et la navigation sans rechargement du site
        if($request -> isXmlHttpRequest()) {
            dump('hello');
            return new JsonResponse(array(
                'langue' => $lang,
                'nombreArticles' => $nombreArticles,
                'nombreUtilisateurs' => $nombreUtilisateurs,
                'nomsCategoriesNewsletter' => $tabNomsCategorieNewsletter,
                'nombreUtilisateursCategorieNewsletter' => $tabNombreUtilisateurs,
                'couleurCategorieNewsletter' => $tabColorCategorieNewsletter
                
            ));
        }      
                 

        return $this->render('admin/welcome.html.twig', [
            'nombreUtilisateurs' => $nombreUtilisateurs,
            'nomsCategoriesNewsletter' => json_encode($tabNomsCategorieNewsletter),
            'nombreUtilisateursCategorieNewsletter' => json_encode($tabNombreUtilisateurs),
            'couleurCategorieNewsletter' => json_encode($couleurCategorieNewsletter)
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Soap Opera')
            ->setTranslationDomain('EasyAdminBundle')
            ->renderContentMaximized();
            
    }

    public function configureMenuItems(): iterable
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')):
            return [
                MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
                // RETOUR A LA PAGE ACCUEIL
                MenuItem::linktoRoute(new TranslatableMessage('menu.homepage', [], 'EasyAdminBundle'), 'fas fa-home', 'home'),
                    // POINTS DE MENU TRIÉS PAR SUBMENUS
                MenuItem::subMenu(new TranslatableMessage('menu.utilisateur', [], 'EasyAdminBundle')) -> setSubItems([
                    MenuItem::linkToCrud(new TranslatableMessage('menu.utilisateur', [], 'EasyAdminBundle'), 'fas fa-user', Utilisateur::class),
                    MenuItem::linkToCrud(new TranslatableMessage('menu.partenaire', [], 'EasyAdminBundle'), 'fas fa-user', Partenaire::class),
                    MenuItem::linkToCrud(new TranslatableMessage('menu.tra_partenaire', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionPartenaire::class),
                    MenuItem::linkToCrud(new TranslatableMessage('menu.adresse', [], 'EasyAdminBundle'), 'fas fa-address-card', Adresse::class),                                        
                    MenuItem::linkToCrud(new TranslatableMessage('menu.langue', [], 'EasyAdminBundle'), 'fas fa-language', Langue::class)
                ]),

                MenuItem::subMenu(new TranslatableMessage('menu.newsletter', [], 'EasyAdminBundle')) -> setSubItems([
                    MenuItem::linkToCrud(new TranslatableMessage('menu.newsletter', [], 'EasyAdminBundle'), 'fas fa-envelope-open-text', Newsletter::class),
                    MenuItem::linkToCrud(new TranslatableMessage('menu.tra_newsletter', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionNewsletter::class),                        
                    MenuItem::linkToCrud(new TranslatableMessage('menu.newsletterCategorie', [], 'EasyAdminBundle'), 'fas fa-plus', NewsletterCategorie::class),
                    MenuItem::linkToCrud(new TranslatableMessage('menu.tra_newsletterCategorie', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionNewsletterCategorie::class)                        
                       
                ]),
            
                MenuItem::subMenu(new TranslatableMessage('menu.article', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.article', [], 'EasyAdminBundle'), 'fas fa-warehouse', Article::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_article', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionArticle::class),                        
                        MenuItem::linkToCrud(new TranslatableMessage('menu.categorie', [], 'EasyAdminBundle'), 'fas fa-arrow-right', Categorie::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_categorie', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionCategorie::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.promotion', [], 'EasyAdminBundle'), 'fas fa-percent', Promotion::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_promotion', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionPromotion::class),  
                        MenuItem::linkToCrud(new TranslatableMessage('menu.livraison', [], 'EasyAdminBundle'), 'fas fa-truck', Livraison::class), 
                        MenuItem::linkToCrud(new TranslatableMessage('menu.commentaire', [], 'EasyAdminBundle'), 'fas fa-comment', Commentaire::class), 
                        MenuItem::linkToCrud(new TranslatableMessage('menu.evaluation', [], 'EasyAdminBundle'), 'fas fa-star', Evaluation::class), 
                ]),

                MenuItem::subMenu(new TranslatableMessage('menu.ing_article', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.beurre', [], 'EasyAdminBundle'), 'fas fa-plus', Beurre::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_beurre', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionBeurre::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.huile', [], 'EasyAdminBundle'), 'fas fa-plus', Huile::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_huile', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionHuile::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.huile_ess', [], 'EasyAdminBundle'), 'fas fa-plus', HuileEssentiel::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_huile_ess', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionHuileEssentiel::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.odeur', [], 'EasyAdminBundle'), 'fas fa-plus', Odeur::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_odeur', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionOdeur::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.ingredient', [], 'EasyAdminBundle'), 'fas fa-plus', IngredientSupplementaire::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_ingredient', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionIngredientSupplementaire::class)                          
                ]),
                
                MenuItem::subMenu(new TranslatableMessage('menu.event', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.event', [], 'EasyAdminBundle'), 'fas fa-calendar', Event::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_event', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionEvent::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.typ', [], 'EasyAdminBundle'), 'fas fa-calendar', TypeEvent::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_typ', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionTypeEvent::class)
                ]),
                
                MenuItem::subMenu(new TranslatableMessage('menu.comptabilite', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.detail_commande', [], 'EasyAdminBundle'), 'fas fa-barcode', DetailCommandeArticle::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.reservation', [], 'EasyAdminBundle'), 'fas fa-barcode', Reservation::class),       
                        MenuItem::linkToCrud(new TranslatableMessage('menu.facture', [], 'EasyAdminBundle'), 'fas fa-barcode', Facture::class) 
                ]),
                        
                MenuItem::subMenu(new TranslatableMessage('menu.image', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.image', [], 'EasyAdminBundle'), 'fas fa-image', Image::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.pos_image', [], 'EasyAdminBundle'), 'fas fa-image', PositionImage::class)    
                ])
            ]; 
        elseif ($this->isGranted('ROLE_FINANCE_ADMIN')):
            return [
                MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
                // RETOUR A LA PAGE ACCUEIL
                MenuItem::linktoRoute(new TranslatableMessage('menu.homepage', [], 'EasyAdminBundle'), 'fas fa-home', 'home'), 
                MenuItem::subMenu(new TranslatableMessage('menu.comptabilite', [], 'EasyAdminBundle')) -> setSubItems([
                    MenuItem::linkToCrud(new TranslatableMessage('menu.detail_commande', [], 'EasyAdminBundle'), 'fas fa-barcode', DetailCommandeArticle::class),
                    MenuItem::linkToCrud(new TranslatableMessage('menu.reservation', [], 'EasyAdminBundle'), 'fas fa-barcode', Reservation::class),       
                    MenuItem::linkToCrud(new TranslatableMessage('menu.facture', [], 'EasyAdminBundle'), 'fas fa-barcode', Facture::class) 
                ])
            ];
        endif;
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
        ->addWebpackEncoreEntry('js/app')
        ->addWebpackEncoreEntry('css/app');
    }
}
