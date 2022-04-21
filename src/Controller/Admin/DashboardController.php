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
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Soap Opera');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
       // back to homepage
       yield MenuItem::linktoRoute('Zurück zur Webseite', 'fas fa-home', 'home');
       // entities sorted by sections
       yield MenuItem::section('Nutzer');
       yield MenuItem::linkToCrud('Nutzer', 'fas fa-user', Utilisateur::class);
       yield MenuItem::linkToCrud('Partner', 'fas fa-user', Partenaire::class);
       yield MenuItem::linkToCrud('Adressen', 'fas fa-address-card', Adresse::class);
       yield MenuItem::linkToCrud('Kommentare', 'fas fa-comment', Commentaire::class);
       yield MenuItem::linkToCrud('Newsletter', 'fas fa-envelope-open-text', Newsletter::class);
       yield MenuItem::section('Artikel');
       yield MenuItem::linkToCrud('Artikel', 'fas fa-warehouse', Article::class);
       yield MenuItem::linkToCrud('Zutaten-Butter', 'fas fa-plus', Beurre::class);
       yield MenuItem::linkToCrud('Zutaten-Öle', 'fas fa-plus', Huile::class);
       yield MenuItem::linkToCrud('Zutaten-Ätherische Öle', 'fas fa-plus', HuileEssentiel::class);
       yield MenuItem::linkToCrud('Zutaten-Düfte', 'fas fa-plus', Odeur::class);
       yield MenuItem::linkToCrud('Zutaten-Zusätze', 'fas fa-plus', IngredientSupplementaire::class);
       yield MenuItem::linkToCrud('Kategorien', 'fas fa-arrow-right', Categorie::class);
       yield MenuItem::linkToCrud('Promotionen', 'fas fa-percent', Promotion::class);
       yield MenuItem::section('Veranstaltungen');
       yield MenuItem::linkToCrud('Veranstaltungen', 'fas fa-calendar', Event::class);
       yield MenuItem::linkToCrud('Veranstaltungstyp', 'fas fa-calendar', TypeEvent::class);
       yield MenuItem::section('Buchhaltung');
       yield MenuItem::linkToCrud('Detail-Bestellungen', 'fas fa-barcode', DetailCommandeArticle::class);
       yield MenuItem::linkToCrud('Reservierungen', 'fas fa-barcode', Reservation::class);       
       yield MenuItem::linkToCrud('Rechnungen', 'fas fa-barcode', Facture::class);       
       yield MenuItem::section('Fotos');
       yield MenuItem::linkToCrud('Fotos', 'fas fa-image', Image::class);
       yield MenuItem::linkToCrud('Position Fotos', 'fas fa-image', PositionImage::class);
       yield MenuItem::section('Übersetzungen');
       yield MenuItem::linkToCrud('Sprachen', 'fas fa-language', Langue::class);       
       yield MenuItem::linkToCrud('Übersetzungen Artikel', 'fas fa-globe', TraductionArticle::class);
       yield MenuItem::linkToCrud('Übersetzungen Butter', 'fas fa-globe', TraductionBeurre::class);
       yield MenuItem::linkToCrud('Übersetzungen Kategorie', 'fas fa-globe', TraductionCategorie::class);
       yield MenuItem::linkToCrud('Übersetzungen Veranstaltung', 'fas fa-globe', TraductionEvent::class);
       yield MenuItem::linkToCrud('Übersetzungen Öl', 'fas fa-globe', TraductionHuile::class);
       yield MenuItem::linkToCrud('Übersetzungen Ätherisches Öl', 'fas fa-globe', TraductionHuileEssentiel::class);
       yield MenuItem::linkToCrud('Übersetzungen Zusatz', 'fas fa-globe', TraductionIngredientSupplementaire::class);
       yield MenuItem::linkToCrud('Übersetzungen Newsletter', 'fas fa-globe', TraductionNewsletter::class);
       yield MenuItem::linkToCrud('Übersetzungen Düfte', 'fas fa-globe', TraductionOdeur::class);
       yield MenuItem::linkToCrud('Übersetzungen Partner', 'fas fa-globe', TraductionPartenaire::class);
       yield MenuItem::linkToCrud('Übersetzungen Promotion', 'fas fa-globe', TraductionPromotion::class);
       yield MenuItem::linkToCrud('Übersetzungen Veranstaltungstyp', 'fas fa-globe', TraductionTypeEvent::class);
       
    }
}
