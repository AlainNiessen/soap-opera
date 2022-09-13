<?php

namespace App\Controller\Admin;

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
use App\Entity\Evaluation;
use App\Entity\Newsletter;
use App\Entity\Commentaire;
use App\Entity\Philosophie;
use App\Entity\Utilisateur;
use App\Entity\PointDeVente;
use App\Entity\PositionImage;
use App\Entity\HuileEssentiel;
use App\Entity\TraductionHuile;
use App\Entity\TraductionOdeur;
use App\Entity\TraductionBeurre;
use App\Entity\TraductionArticle;
use App\Entity\NewsletterCategorie;
use App\Entity\TraductionCategorie;
use App\Entity\TraductionPromotion;
use App\Entity\TraductionNewsletter;
use App\Entity\DetailCommandeArticle;
use App\Entity\TraductionPointDeVente;
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
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Translation\TranslatableMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{  
    // ----------------------------
    // ROUTE POUR INTERFACE ADMINISTRATION
    // ----------------------------

    /**
     * @Route("/admin_s_op", name="admin_s_op")
     */
    public function interface(Request $request, EntityManagerInterface $entityManager): Response
    {
        //récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);      
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 
        
        // récupération des informations pour les statistiques générales
        // récupération du nombre des utilisateurs via UtilisateurRepository
        $repositoryUtilisateur = $entityManager -> getRepository(Utilisateur::class);
        $nombreUtilisateurs = $repositoryUtilisateur -> countUtilisateurs();
        // récupération du nombre des articles et nombre des articles vendus via ArticleRepository
        $repositoryArticles = $entityManager -> getRepository(Article::class);
        $nombreArticles = $repositoryArticles -> countArticles();
        $nombreArticlesVendus = $repositoryArticles -> countArticlesVendus();
        // récupération du nombre des factures via FactureRepository
        $repositoryFactures = $entityManager -> getRepository(Facture::class);
        $nombreFactures = $repositoryFactures -> countFactures();
                
        // récupération de toutes les catégories de Newsletter via NewsletterCategorieRepository
        $repositoryCategorieNewsletter = $entityManager -> getRepository(NewsletterCategorie::class);
        $categoriesNewsletter = $repositoryCategorieNewsletter -> findAll();
        // récupération du Repository TraductionCategorieNewsletter
        $repositoryTraductionCategorieNewsletter = $entityManager -> getRepository(TraductionNewsletterCategorie::class);
              
        // préparation des informations
        $tabNombreUtilisateurs = [];
        $tabNomsCategorieNewsletter = [];
        $tabColorCategorieNewsletter = [];
        // boucle sur les catégories de Newsletter
        foreach($categoriesNewsletter as $categorieNewsletter):
            // récupération du nombre des utilisateur par catégorie de Newsletter
            $utilisateurs = $categorieNewsletter -> getUtilisateurs();
            $nombreUtilisateursCategorieNewsletter = count($utilisateurs);
            // récupération de la couleur pour les statistiques
            $couleurCategorieNewsletter = $categorieNewsletter -> getCouleur();
            // récupération de la traduction de la catégorie de Newsletter basée sur la langue stockée dans la Session
            $traductionNewsletter = $repositoryTraductionCategorieNewsletter -> findTraduction($categorieNewsletter, $lang); 
            // collection des informations pour construire la statistique           
            $tabNomsCategorieNewsletter[] = $traductionNewsletter->getNom();
            $tabNombreUtilisateurs[] = $nombreUtilisateursCategorieNewsletter;
            $tabColorCategorieNewsletter[] = $couleurCategorieNewsletter;
        endforeach;

        // récupération de toutes les catégories des articles via CategorieRepository
        $repositoryCategorieArticle = $entityManager -> getRepository(Categorie::class);
        $categoriesArticle = $repositoryCategorieArticle -> findAll();
        // récupération du Repository TraductionCategorie
        $repositoryTraductionCategorieArticle = $entityManager -> getRepository(TraductionCategorie::class);
             
        // préparation des informations       
        $tabNombreVentes = [];
        $tabNomsCategorieArticle = [];
        $tabColorCategorieArticle = [];
        // boucle sur les catégories de Newsletter
        foreach($categoriesArticle as $categorieArticle):
            // récupération du nombre des articles par catégorie
            $nombreVentesCategorie =  $repositoryArticles -> countArticlesCategorie($categorieArticle);
            // récupération de la couleur pour les statistiques
            $couleurCategorieArticle = $categorieArticle -> getCouleur();            
            // récupération de la traduction de la catégorie basée sur la langue stockée dans la Session
            $traductionCategorie = $repositoryTraductionCategorieArticle -> findTraductionCategorie($categorieArticle, $langue);
            // collection des informations pour construire la statistique
            $tabNomsCategorieArticle[] = $traductionCategorie->getNom();
            $tabNombreVentes[] = $nombreVentesCategorie;
            $tabColorCategorieArticle[] = $couleurCategorieArticle;
        endforeach;
       
        // actualisation des statistiques via une requête AJAX
        if($request -> isXmlHttpRequest()) {  
            // réponse avec toutes les informations pour actualiser les statistiques          
            return new JsonResponse(array(
                'langue' => $lang,
                'nombreArticles' => $nombreArticles,
                'nombreUtilisateurs' => $nombreUtilisateurs,
                'nombreArticlesVendus' =>  $nombreArticlesVendus,
                'nombreFactures' =>  $nombreFactures,
                'nombreVentesParCategorie' => $tabNombreVentes,
                'nomsCategoriesArticle' => $tabNomsCategorieArticle,
                'couleurCategorieArticle' => $tabColorCategorieArticle,
                'nomsCategoriesNewsletter' => $tabNomsCategorieNewsletter,
                'nombreUtilisateursCategorieNewsletter' => $tabNombreUtilisateurs,
                'couleurCategorieNewsletter' => $tabColorCategorieNewsletter
                
            ));
        } 

        return $this->render('admin/welcome.html.twig');
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
        // si l'administrateur avec le rôle SUPER_ADMIN se connecte
        if ($this->isGranted('ROLE_SUPER_ADMIN')):
            return [
                MenuItem::linkToRoute('Dashboard', 'fa fa-home', 'admin_s_op'),
                // retour à la page d'accueil
                MenuItem::linktoRoute(new TranslatableMessage('menu.homepage', [], 'EasyAdminBundle'), 'fas fa-home', 'home'),
                // points de menus avec des sous-menus
                MenuItem::subMenu(new TranslatableMessage('menu.utilisateur', [], 'EasyAdminBundle')) -> setSubItems([
                    MenuItem::linkToCrud(new TranslatableMessage('menu.utilisateur', [], 'EasyAdminBundle'), 'fas fa-user', Utilisateur::class),
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
                
                MenuItem::subMenu(new TranslatableMessage('menu.pointDeVente', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.pointDeVente', [], 'EasyAdminBundle'), 'fas fa-home', PointDeVente::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.tra_pointDeVente', [], 'EasyAdminBundle'), 'fas fa-globe', TraductionPointDeVente::class),
                        
                ]),
                
                MenuItem::subMenu(new TranslatableMessage('menu.comptabilite', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.detail_commande', [], 'EasyAdminBundle'), 'fas fa-barcode', DetailCommandeArticle::class),       
                        MenuItem::linkToCrud(new TranslatableMessage('menu.facture', [], 'EasyAdminBundle'), 'fas fa-barcode', Facture::class) 
                ]),
                        
                MenuItem::subMenu(new TranslatableMessage('menu.image', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.image', [], 'EasyAdminBundle'), 'fas fa-image', Image::class),
                        MenuItem::linkToCrud(new TranslatableMessage('menu.pos_image', [], 'EasyAdminBundle'), 'fas fa-image', PositionImage::class)    
                ]),
                MenuItem::subMenu(new TranslatableMessage('menu.philosophie', [], 'EasyAdminBundle')) -> setSubItems([
                        MenuItem::linkToCrud(new TranslatableMessage('menu.philosophie', [], 'EasyAdminBundle'), 'fas fa-image', Philosophie::class)                            
                ])
            ]; 
        // si l'administrateur avec le rôle FINANCE_ADMIN se connecte
        elseif ($this->isGranted('ROLE_FINANCE_ADMIN')):
            return [
                MenuItem::linkToRoute('Dashboard', 'fa fa-home', 'admin_s_op'),
                // RETOUR A LA PAGE ACCUEIL
                MenuItem::linktoRoute(new TranslatableMessage('menu.homepage', [], 'EasyAdminBundle'), 'fas fa-home', 'home'), 
                MenuItem::subMenu(new TranslatableMessage('menu.comptabilite', [], 'EasyAdminBundle')) -> setSubItems([
                    MenuItem::linkToCrud(new TranslatableMessage('menu.detail_commande', [], 'EasyAdminBundle'), 'fas fa-barcode', DetailCommandeArticle::class),       
                    MenuItem::linkToCrud(new TranslatableMessage('menu.facture', [], 'EasyAdminBundle'), 'fas fa-barcode', Facture::class) 
                ])
            ];
        endif;
    }

    public function configureAssets(): Assets
    {
        // ajout des ENTRYPOINTS pour pouvoir utiliser WebpackEncore pour l'interface administrateur
        return Assets::new()
        ->addWebpackEncoreEntry('js/app')
        ->addWebpackEncoreEntry('css/app');
    }
}
