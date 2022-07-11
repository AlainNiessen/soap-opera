<?php

namespace App\Controller;

use DateTime;
use Stripe\Stripe;
use App\Entity\Langue;
use App\Entity\Article;
use App\Entity\Facture;
use App\Entity\Livraison;
use Stripe\Checkout\Session;
use App\Entity\TraductionArticle;
use Symfony\Component\Mime\Address;
use App\Controller\PanierController;
use App\Entity\DetailCommandeArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{
    /**
     * @Route("/paiement/{total}", name="paiement", methods="post|get")
     */
    //injection de la clé secret de STRIPE défini dans services.yaml et .env
    public function paiement($total, $stripeSK, TranslatorInterface $translator): Response
    {
        // remplacement des "," par des "." (pour le float)
        $total = str_replace(',', '.', $total);        
        // changement du montant en float et total en centimes
        $total = floatval($total) * 100;
        // changement du float vers int
        $total = intval($total);    
        
        // définition de la clé de l'API
        // => clé secret passé par la platform Stripe
        Stripe::setApiKey($stripeSK);

        // nom pour la commande
        $nom = $translator -> trans('Deine Bestellung');

        //transfer des données de la transaction à Stripe
        $session = Session::create([
            'line_items' => [[
              'price_data' => [
                'currency' => 'eur', // Dans quelle devise le paiement doit-il être effectué ?
                'product_data' => [
                  'name' => $nom, // Nom pour les données du produit => dans mon cas => juste "Ta commande"
                ],
                'unit_amount' => $total, // Montant total transféré par l'URL, transformé d'abord en float * 100, aprés en integer (exemple: "20,50" => 2050)
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this -> generateUrl('succes', [], UrlGeneratorInterface::ABSOLUTE_URL), // redirection de Stripe en cas de succés (URL complét (ABSOLUTE) car redirection viens de Stripe)
            'cancel_url' => $this -> generateUrl('cancel', [], UrlGeneratorInterface::ABSOLUTE_URL), // redirection de Stripe en cas de échec (URL complét (ABSOLUTE) car redirection viens de Stripe)
          ]);
        
          // redirect vers l'interface de Stripe avec code 303 pour redirect
          return $this -> redirect($session -> url, 303);
    }

    /**
     * @Route("/succes", name="succes")
     */
    public function succes(SessionInterface $session, EntityManagerInterface $entityManager, TranslatorInterface $translator, MailerInterface $mailer, Request $request): Response
    {

        // création facture
        $facture = new Facture();
        $facture -> setDateFacture(new DateTime());
        $facture -> setStatutPaiement(true);
        $facture -> setStatutLivraison(false);
        $facture -> setUtilisateur($this -> getUser());
        $facture -> setMontantTotalHorsTva(0.00);
        $facture -> setMontantTotalTva(0.00);
        $facture -> setMontantTotal(0.00);
        //préparation insertion dans la BD
        $entityManager -> persist($facture);
        //insertion BD
        $entityManager -> flush();
        
        // on récupére le panier actuel de la Session
        // on boucle sur le panier pour créer des détails de commandes par article dasn le panier
        $panier = $session -> get('panier', []);
        foreach($panier as $id => $quantite):            
          // récupération de l'article via son ID
          // définition repository article
          $repositoryArticle = $entityManager -> getRepository(Article::class);
          $article = $repositoryArticle -> findOneBy(['id' => $id]);

          //actualisation de la quantité de ventes par article dans l'entité article
          $nombreVentes = $article -> getNombreVentes();
          $nombreVentes += $quantite;
          $article -> setNombreVentes($nombreVentes);
          //préparation insertion dans la BD
          $entityManager -> persist($article);
          //insertion BD
          $entityManager -> flush();

          // si il y a une réduction sur le prix
          if($article -> getPromotion() || $article -> getCategorie() -> getPromotion()):
            if($article -> getPromotion()):
                $reduction = $article -> getMontantHorsTva() * $article -> getPromotion() -> getPourcentage();                    
            elseif($article -> getCategorie() -> getPromotion()):
                $reduction = $article -> getMontantHorsTva() * $article -> getCategorie() -> getPromotion() -> getPourcentage();
            endif;
            $prixNette = ($article -> getMontantHorsTva()) - $reduction;                
          else:
              $prixNette = $article -> getMontantHorsTva();                    
          endif;

          // calculs sur base du prix nette          
          $prixHorsTva = (round($prixNette / 100, 2) * $quantite) * 100;
          $prixTva = (round(($prixNette * $article -> getTauxTva()) / 100, 2) * $quantite) * 100;
          $prixTotalArticle = $prixHorsTva + $prixTva;         

          //création détail de commande par article dans le panier
          $commande = new DetailCommandeArticle();
          $commande -> setQuantite($quantite);
          $commande -> setArticle($article);
          $commande -> setMontantTotalHorsTva($prixHorsTva);
          $commande -> setMontantTva($prixTva);
          $commande -> setMontantTotal($prixTotalArticle);
          $commande -> setFacture($facture);
          // ajout des totaux à la facture correspondante
          $factMontantTotalHorsTva = $facture -> getMontantTotalHorsTva();
          $factMontantTotalHorsTva += $commande -> getMontantTotalHorsTva();
          $facture -> setMontantTotalHorsTva($factMontantTotalHorsTva);

          $factMontantTotalTva = $facture -> getMontantTotalTva();
          $factMontantTotalTva += $commande -> getMontantTva();
          $facture -> setMontantTotalTva($factMontantTotalTva);

          $factMontantTotal = $facture -> getMontantTotal();
          $factMontantTotal += $commande -> getMontantTotal();
          $facture -> setMontantTotal($factMontantTotal);

          //préparation insertion dans la BD
          $entityManager -> persist($commande);
          $entityManager -> persist($facture);
          //insertion BD
          $entityManager -> flush();      

        endforeach;

        // envoie d'un mail de confirmation de l'achat à l'utilisateur connecté
        // appel à la fonction qui traite toutes les informations pour les afficher par aprés dans le Mail comme résumé
        $tabInfos = $this->infoArticlePanier($panier, $entityManager, $request);
         
        //sujet à traduire
        $messageSubject = $translator -> trans('Kaufbestätigung - Rechnung Nr.');
        //validation par mail après enregistrement de l'utilisateur
        $email = (new TemplatedEmail())
        ->from('alain_niessen@hotmail.com') //de qui
        ->to(new Address($this -> getUser() -> getEmail())) //vers adresse mail du utilisateur
        ->subject($messageSubject.' '. $facture->getId()) //sujet
        ->htmlTemplate('emails/confirmationAchat.html.twig') //création template email confirmationAchat
        ->context([
            //passage des informations au template twig (token)
            'nom' => $this -> getUser() -> getPrenom(),
            'infosPanier' => $tabInfos[0],
            'total' => $tabInfos[1],
            'fraisLivraison' => $tabInfos[2]           
        ]);
        // envoi du mail
        $mailer -> send($email);  

        // reste du panier et nombre total des articles dans le panier
        $session -> set('panier', []);
        $session -> set('nombreArticles', 0);

        return $this -> render('paiement/succes.html.twig');
    }

    /**
     * @Route("/cancel", name="cancel")
     */
    public function cancel(): Response
    {        

        return $this -> render('paiement/cancel.html.twig');
    }

    function infoArticlePanier($panier, EntityManagerInterface $entityManager, Request $request)
    {
        // initialisation des variables
        $infosPanier = [];
        $prixTotal = 0;
        $infoComplete = [];

        //récupération langue
        $lang = $request-> getLocale();
        //définition repository langue
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);

        // récupération du pays de l'adresse de livraison de l'utilisateur connecté pour calculer les frais de livraison
        $paysLivraison = $this -> getUser() -> getAdresseDeliver() -> getPays();
        // récupération du montant des frais de livraison
        // définition repository langue
        $repositoryLivraison = $entityManager -> getRepository(Livraison::class);
        // fonction de requête sur base de données récupérées       
        $livraison = $repositoryLivraison -> findOneBy(['pays' => $paysLivraison]);
        // frais de livraison
        $fraisLivraison = ($livraison -> getPrix()) / 100;
        
        
        // boucle sur le panier
        foreach($panier as $id => $quantite):
            
            // récupération de l'article via son ID
            // définition repository article
            $repositoryArticle = $entityManager -> getRepository(Article::class);
            $article = $repositoryArticle -> findOneBy(['id' => $id]);

            
            // prix final du article + prix final de tous les articles
            // si il y a une réduction sur le prix
            if($article -> getPromotion() || $article -> getCategorie() -> getPromotion()):
                if($article -> getPromotion()):
                    $reduction = $article -> getMontantHorsTva() * $article -> getPromotion() -> getPourcentage();                    
                elseif($article -> getCategorie() -> getPromotion()):
                    $reduction = $article -> getMontantHorsTva() * $article -> getCategorie() -> getPromotion() -> getPourcentage();
                endif;
                $prixNette = ($article -> getMontantHorsTva()) - $reduction;                
            else:
                $prixNette = $article -> getMontantHorsTva();                    
            endif;

            // calculs sur base du prix nette
            $prixHorsTva = round($prixNette / 100, 2);
            $prixTva = round(($prixNette * $article -> getTauxTva()) / 100, 2);
            $prixTotalArticle = $prixHorsTva + $prixTva;
            $prixTotalArticleQuantite = $prixTotalArticle * $quantite;            
            $prixTotal += $prixTotalArticleQuantite;

            // formats d'affichage
            $prixHorsTva = number_format($prixHorsTva, 2, ',', '.');
            $prixTva = number_format($prixTva, 2, ',', '.');
            $prixTotalArticle = number_format($prixTotalArticle, 2, ',', '.');
            $prixTotalArticleQuantite = number_format($prixTotalArticleQuantite, 2, ',', '.');           

            //récupération de la traduction de l'article           
            $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
            $resultTraduction = $repositoryTraductionArticle -> findOneBy(['langue' => $langue, 'article' => $article]);
            
            //stockage de article + son quantité dans le tableau infosPanier
            $infosPanier[] = [
                "article" => $article,
                "prixHorsTva" => $prixHorsTva,
                "prixTva" => $prixTva,
                "prixTotal" => $prixTotalArticle,
                "prixTotalQuantite" => $prixTotalArticleQuantite,
                "traduction" => $resultTraduction,
                "quantite" => $quantite
            ];                      
        endforeach;

        // condition si le prix total est supérieur de 100 Euro, pas de frais de livraison
        
        if($prixTotal >= 100):
            $fraisLivraison = 0;
        endif;

        $prixTotal += $fraisLivraison;
        $prixTotal = number_format($prixTotal, 2, ',', '.');
        $fraisLivraison = number_format($fraisLivraison, 2, ',', '.');

        $infoComplete[] = $infosPanier;
        $infoComplete[] = $prixTotal;
        $infoComplete[] = $fraisLivraison;
        
        return $infoComplete;
    }
}
