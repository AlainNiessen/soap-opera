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
use App\Entity\Promotion;
use App\Entity\TypeEvent;
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
use App\Entity\TraductionCategorie;
use App\Entity\TraductionPromotion;
use App\Entity\TraductionTypeEvent;
use App\Entity\TraductionNewsletter;
use App\Entity\TraductionPartenaire;
use App\Entity\DetailCommandeArticle;
use App\Entity\IngredientSupplementaire;
use App\Entity\TraductionHuileEssentiel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TraductionIngredientSupplementaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin_s_op", name="admin_s_op")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Soap Opera')
            ->setTranslationDomain('messages');
    }

    public function configureMenuItems(): iterable
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')):
            return [
                MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
                // RETOUR A LA PAGE ACCUEIL
                MenuItem::linktoRoute('Zurück zur Webseite', 'fas fa-home', 'home'),
                    // POINTS DE MENU TRIÉS PAR SUBMENUS
                MenuItem::subMenu('Nutzer') -> setSubItems([
                    MenuItem::linkToCrud('Nutzer', 'fas fa-user', Utilisateur::class),
                    MenuItem::linkToCrud('Partner', 'fas fa-user', Partenaire::class),
                    MenuItem::linkToCrud('Trans Partner', 'fas fa-globe', TraductionPartenaire::class),
                    MenuItem::linkToCrud('Adressen', 'fas fa-address-card', Adresse::class),
                    MenuItem::linkToCrud('Kommentare', 'fas fa-comment', Commentaire::class),
                    MenuItem::linkToCrud('Newsletter', 'fas fa-envelope-open-text', Newsletter::class),
                    MenuItem::linkToCrud('Trans Newsletter', 'fas fa-globe', TraductionNewsletter::class),
                    MenuItem::linkToCrud('Sprachen', 'fas fa-language', Langue::class)
                ]),
            
                MenuItem::subMenu('Artikel') -> setSubItems([
                        MenuItem::linkToCrud('Artikel', 'fas fa-warehouse', Article::class),
                        MenuItem::linkToCrud('Trans Artikel', 'fas fa-globe', TraductionArticle::class),                        
                        MenuItem::linkToCrud('Kategorien', 'fas fa-arrow-right', Categorie::class),
                        MenuItem::linkToCrud('Trans Kategorie', 'fas fa-globe', TraductionCategorie::class),
                        MenuItem::linkToCrud('Promotionen', 'fas fa-percent', Promotion::class),
                        MenuItem::linkToCrud('Trans Promotion', 'fas fa-globe', TraductionPromotion::class)   
                ]),

                MenuItem::subMenu('Zutaten-Artikel') -> setSubItems([
                        MenuItem::linkToCrud('Butter', 'fas fa-plus', Beurre::class),
                        MenuItem::linkToCrud('Trans Butter', 'fas fa-globe', TraductionBeurre::class),
                        MenuItem::linkToCrud('Öle', 'fas fa-plus', Huile::class),
                        MenuItem::linkToCrud('Trans Öle', 'fas fa-globe', TraductionHuile::class),
                        MenuItem::linkToCrud('Ätherische Öle', 'fas fa-plus', HuileEssentiel::class),
                        MenuItem::linkToCrud('Trans Ätherisches Öle', 'fas fa-globe', TraductionHuileEssentiel::class),
                        MenuItem::linkToCrud('Düfte', 'fas fa-plus', Odeur::class),
                        MenuItem::linkToCrud('Trans Düfte', 'fas fa-globe', TraductionOdeur::class),
                        MenuItem::linkToCrud('Zusätze', 'fas fa-plus', IngredientSupplementaire::class),
                        MenuItem::linkToCrud('Trans Zusätze', 'fas fa-globe', TraductionIngredientSupplementaire::class)                          
                ]),
                
                MenuItem::subMenu('Veranstaltungen') -> setSubItems([
                        MenuItem::linkToCrud('Veranstaltungen', 'fas fa-calendar', Event::class),
                        MenuItem::linkToCrud('Trans Veranstaltung', 'fas fa-globe', TraductionEvent::class),
                        MenuItem::linkToCrud('Typ', 'fas fa-calendar', TypeEvent::class),
                        MenuItem::linkToCrud('Trans Typ', 'fas fa-globe', TraductionTypeEvent::class)
                ]),
                
                MenuItem::subMenu('Buchhaltung') -> setSubItems([
                        MenuItem::linkToCrud('Detail-Bestellungen', 'fas fa-barcode', DetailCommandeArticle::class),
                        MenuItem::linkToCrud('Reservierungen', 'fas fa-barcode', Reservation::class),       
                        MenuItem::linkToCrud('Rechnungen', 'fas fa-barcode', Facture::class) 
                ]),
                        
                MenuItem::subMenu('Fotos') -> setSubItems([
                        MenuItem::linkToCrud('Fotos', 'fas fa-image', Image::class),
                        MenuItem::linkToCrud('Position Fotos', 'fas fa-image', PositionImage::class)    
                ])
            ]; 
        elseif ($this->isGranted('ROLE_FINANCE_ADMIN')):
            return [
                MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
                // RETOUR A LA PAGE ACCUEIL
                MenuItem::linktoRoute('Zurück zur Webseite', 'fas fa-home', 'home'), 
                MenuItem::subMenu('Buchhaltung') -> setSubItems([
                    MenuItem::linkToCrud('Detail-Bestellungen', 'fas fa-barcode', DetailCommandeArticle::class),
                    MenuItem::linkToCrud('Reservierungen', 'fas fa-barcode', Reservation::class),       
                    MenuItem::linkToCrud('Rechnungen', 'fas fa-barcode', Facture::class) 
                ])
            ];
        endif;
    }
}
