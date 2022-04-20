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
use App\Entity\TypeEvent;
use App\Entity\Newsletter;
use App\Entity\Partenaire;
use App\Entity\Commentaire;
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
       // entity
       yield MenuItem::linkToCrud('Adressen', 'fas fa-address-card', Adresse::class);
       yield MenuItem::linkToCrud('Artikel', 'fas fa-address-card', Article::class);
       yield MenuItem::linkToCrud('Zutaten-Butter', 'fas fa-address-card', Beurre::class);
       yield MenuItem::linkToCrud('Zutaten-Öle', 'fas fa-address-card', Huile::class);
       yield MenuItem::linkToCrud('Zutaten-Ätherische Öle', 'fas fa-address-card', HuileEssentiel::class);
       yield MenuItem::linkToCrud('Zutaten-Düfte', 'fas fa-address-card', Odeur::class);
       yield MenuItem::linkToCrud('Zutaten-Zusätze', 'fas fa-address-card', IngredientSupplementaire::class);
       yield MenuItem::linkToCrud('Kategorien', 'fas fa-address-card', Categorie::class);
       yield MenuItem::linkToCrud('Kommentare', 'fas fa-address-card', Commentaire::class);
       yield MenuItem::linkToCrud('Detail-Bestellungen', 'fas fa-address-card', DetailCommandeArticle::class);
       yield MenuItem::linkToCrud('Veranstaltungen', 'fas fa-address-card', Event::class);
       yield MenuItem::linkToCrud('Rechnungen', 'fas fa-address-card', Facture::class);
       yield MenuItem::linkToCrud('Fotos', 'fas fa-address-card', Image::class);
       yield MenuItem::linkToCrud('Sprachen', 'fas fa-address-card', Langue::class);
       yield MenuItem::linkToCrud('Newsletter', 'fas fa-address-card', Newsletter::class);
       yield MenuItem::linkToCrud('Partner', 'fas fa-address-card', Partenaire::class);
       yield MenuItem::linkToCrud('Position Fotos', 'fas fa-address-card', PositionImage::class);
       yield MenuItem::linkToCrud('Übersetzungen Artikel', 'fas fa-address-card', TraductionArticle::class);
       yield MenuItem::linkToCrud('Übersetzungen Butter', 'fas fa-address-card', TraductionBeurre::class);
       yield MenuItem::linkToCrud('Übersetzungen Kategorie', 'fas fa-address-card', TraductionCategorie::class);
       yield MenuItem::linkToCrud('Übersetzungen Veranstaltung', 'fas fa-address-card', TraductionEvent::class);
       yield MenuItem::linkToCrud('Übersetzungen Öl', 'fas fa-address-card', TraductionHuile::class);
       yield MenuItem::linkToCrud('Übersetzungen Ätherisches Öl', 'fas fa-address-card', TraductionHuileEssentiel::class);
       yield MenuItem::linkToCrud('Übersetzungen Zusatz', 'fas fa-address-card', TraductionIngredientSupplementaire::class);
       yield MenuItem::linkToCrud('Übersetzungen Newsletter', 'fas fa-address-card', TraductionNewsletter::class);
       yield MenuItem::linkToCrud('Übersetzungen Düfte', 'fas fa-address-card', TraductionOdeur::class);
       yield MenuItem::linkToCrud('Übersetzungen Partner', 'fas fa-address-card', TraductionPartenaire::class);
       yield MenuItem::linkToCrud('Übersetzungen Promotion', 'fas fa-address-card', TraductionPromotion::class);
       yield MenuItem::linkToCrud('Übersetzungen Veranstaltungstyp', 'fas fa-address-card', TraductionTypeEvent::class);
       yield MenuItem::linkToCrud('Veranstaltungstyp', 'fas fa-address-card', TypeEvent::class);
       yield MenuItem::linkToCrud('Nutzer', 'fas fa-address-card', Utilisateur::class);
    }
}
