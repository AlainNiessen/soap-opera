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
use Dompdf\Dompdf;
use Dompdf\Options;

class PaiementController extends AbstractController
{
    //----------------------------------------------
    // ROUTE PAIEMENT
    //----------------------------------------------
    /**
     * @Route("/paiement/{total}", name="paiement", methods="post|get")
     */
    // injection de la clé secret de STRIPE défini dans services.yaml et .env
    public function paiement($total, $stripeSK, TranslatorInterface $translator, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        // récupération du panier pour contrôle quantité
        $panier = $session -> get('panier', []);
        $nombreArticles = $session -> get('nombreArticles', 0);
        $poidsTotal = $session -> get('poidsTotal', 0);
        // initiation variable pour contrôle
        $checkPaiement = 0;
        
        foreach($panier as $article ): 
            $articleID = key($article);
            $quantite = reset($article);
            if ($articleID && $quantite):         
                // récupération de l'article via son ID via ArticleRepository
                $repositoryArticle = $entityManager -> getRepository(Article::class);
                $article = $repositoryArticle -> findOneBy(['id' => $articleID]);
                $stockArticle = $article -> getStock();
                $poidsArticle = $article -> getPoids();
                
                
                //contrôle stock avant paiement
                if($stockArticle >= $quantite && $stockArticle > 0):
                    $checkPaiement++;
                elseif($stockArticle < $quantite && $stockArticle > 0):
                    // actualisation quantité 
                    $panier[$articleID][$articleID] = $stockArticle;
                    $panier[$articleID]["stockStart"] = $stockArticle;
                    $session -> set('panier', $panier); 
                    // actualisation poids
                    $poidsTotal -= $poidsArticle * $quantite;
                    $poidsTotal += $poidsArticle * $stockArticle;
                    $session -> set('poidsTotal', $poidsTotal); 
                    // actualisation nombre total des articles dans le panier
                    $nombreArticles -= $quantite;
                    $nombreArticles +=$stockArticle;
                    $session -> set('nombreArticles', $nombreArticles);
                elseif($stockArticle == 0):
                    $checkPaiement--;
                    // supprimer de l'article car stock est 0
                    unset($panier[$articleID]);
                    $session -> set('panier', $panier);
                    // actualisation poids
                    $poidsTotal -= $poidsArticle * $quantite;
                    $session -> set('poidsTotal', $poidsTotal);
                    // actualisation nombre total des articles dans le panier
                    $nombreArticles -= $quantite;
                    $session -> set('nombreArticles', $nombreArticles);                    
                endif;
            endif;
        endforeach;         
              
        if($checkPaiement == count($panier) && !empty($panier)):
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
        else:
            // ajout d'un message de réussite
            $message = $translator -> trans('Ihr Warenkorb wurde dem aktuellen Lagerbestand angepasst!');
            $this -> addFlash('notice', $message);

            return $this->redirectToRoute('panier');
        endif;
    }

    //----------------------------------------------
    // ROUTE PAIEMENT REUSSI 
    //----------------------------------------------
    /**
     * @Route("/succes", name="succes")
     */
    public function succes(SessionInterface $session, EntityManagerInterface $entityManager, TranslatorInterface $translator, MailerInterface $mailer, Request $request): Response
    {
        // 1) INSERTION DES DONNEES DANS LA BASE DE DONNEES

        // création nouvelle facture
        $facture = new Facture();
        $facture -> setDateFacture(new DateTime());
        $facture -> setStatutPaiement(true);
        $facture -> setStatutLivraison(false);
        $facture -> setUtilisateur($this -> getUser());
        $facture -> setMontantTotalHorsTva(0.00);
        $facture -> setMontantTotalTva(0.00);
        $facture -> setMontantTotal(0.00);

        // insertion dans la base de données
        $entityManager -> persist($facture);
        $entityManager -> flush();
        
        // on récupére le panier actuel de la Session
        // on boucle sur le panier pour créer des détails de commandes par article dans le panier
        $panier = $session -> get('panier', []);

        foreach($panier as $article ): 
            $articleID = key($article);
            $quantite = reset($article);
            if ($articleID && $quantite):         
                // récupération de l'article via son ID via ArticleRepository
                $repositoryArticle = $entityManager -> getRepository(Article::class);
                $article = $repositoryArticle -> findOneBy(['id' => $articleID]);

                //actualisation de la quantité de ventes par article dans l'entité article
                $nombreVentes = $article -> getNombreVentes();
                $nombreVentes += $quantite;
                $article -> setNombreVentes($nombreVentes);

                //actualisation de la quantité du stock réel de l'article
                $ancienStock = $article -> getStock();
                $newStock = $ancienStock - $quantite;
                $article -> setStock($newStock);

                // insertion dans la base de données
                $entityManager -> persist($article);
                $entityManager -> flush();

                // calcul des montants
                // si il y a une réduction sur le prix
                if($article -> getPromotion() || $article -> getCategorie() -> getPromotion()):
                    if($article -> getPromotion()):
                        // contrôle des dates d'affichage
                        if($article -> getPromotion() -> getDateStart() < new DateTime('now') && $article -> getPromotion() -> getDateEnd() > new DateTime('now')):
                            $reduction = $article -> getMontantHorsTva() * $article -> getPromotion() -> getPourcentage();
                        else:
                            $reduction = 0;
                        endif;                   
                    elseif($article -> getCategorie() -> getPromotion()):
                        if($article -> getCategorie() -> getPromotion() -> getDateStart() < new DateTime('now') && $article -> getCategorie() -> getPromotion() -> getDateEnd() > new DateTime('now')):
                            $reduction = $article -> getMontantHorsTva() * $article -> getCategorie() -> getPromotion() -> getPourcentage();
                        else:
                            $reduction = 0;
                        endif;
                    endif;
                    $prixHorsTva = ($article -> getMontantHorsTva()) - $reduction;                
                else:
                    $prixHorsTva = $article -> getMontantHorsTva();                    
                endif;

                $prixTotalHorsTva = intval($prixHorsTva) * $quantite;

                // condition si utilisateur est une entreprise allemande avec numéro TVA
                if($this -> getUser() -> getAdresseDeliver() -> getPays() === "DE" && $this -> getUser() -> getNumeroTVA()):
                    $prixTotalTva = 0;
                else:
                    $prixTva = intval(round(round(($prixHorsTva * $article -> getTauxTva()), 2)), 0);
                    $prixTotalTva = $prixTva * $quantite;
                endif;          
                
                $prixTotalArticle = $prixTotalHorsTva + $prixTotalTva;      
            

                //création détail de commande par article dans le panier
                $commande = new DetailCommandeArticle();
                $commande -> setQuantite($quantite);
                $commande -> setArticle($article);
                $commande -> setMontantTotalHorsTva($prixTotalHorsTva);
                $commande -> setMontantTva($prixTotalTva);
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

                // insertion dans la base de données
                $entityManager -> persist($commande);
                $entityManager -> persist($facture);
                $entityManager -> flush();
            endif;
        endforeach;

        // récupération du poid total
        $poidsTotal = $session -> get('poidsTotal'); 
        // récupération du pays de l'adresse de livraison de l'utilisateur connecté pour calculer les frais de livraison
        $paysLivraison = $this -> getUser() -> getAdresseDeliver() -> getPays();
        // récupération du montant des frais de livraison via LivraisonRepository
        $repositoryLivraison = $entityManager -> getRepository(Livraison::class);            
        $livraisons = $repositoryLivraison -> findOneBy(['pays' => $paysLivraison]);
        foreach($livraisons as $livraison):
            if($poidsTotal >= 2000):
                $liv = $repositoryLivraison -> findOneBy(['niveau' => 2]);
            else:
                $liv = $repositoryLivraison -> findOneBy(['niveau' => 1]);
            endif;
        endforeach;
        
        // frais de livraison
        $fraisLivraison = ($liv -> getMontantHorsTva()) / 100;
        
        // condition si le prix total est supérieur de 100 Euro, pas de frais de livraison 
        $prixTotal = $factMontantTotal / 100; 
            
        // condition si l'utilisateur a activé le service de ramassage
        if($this->getUser()->getRamassage() == true):
            $fraisLivraison = 0;
            $montantTvaLivraison = 0;
            $montantTotalLivraison = 0;
        else:
            // condition si le prix total est supérieur de 100 Euro, pas de frais de livraison        
            if($prixTotal < 100):
                // Calculs
                $fraisLivraison = round($fraisLivraison, 2);
                // condition si utilisateur est une entreprise allemande avec numéro TVA
                if($this -> getUser() -> getAdresseDeliver() -> getPays() === "DE" && $this -> getUser() -> getNumeroTVA()):
                    $montantTvaLivraison = 0;
                else:
                    $montantTvaLivraison = round(($fraisLivraison * $livraison -> getTauxTva()), 2);
                endif;
                
                $montantTotalLivraison = $fraisLivraison + $montantTvaLivraison; 
            else:
                $fraisLivraison = 0;
                $montantTvaLivraison = 0;
                $montantTotalLivraison = 0;            
            endif;
        endif;


        
        // ajout des frais de livraison aux totaux de la facture
        $factMontantTotalHorsTva = $facture -> getMontantTotalHorsTva();
        $factMontantTotalHorsTva += $fraisLivraison;
        $facture -> setMontantTotalHorsTva($factMontantTotalHorsTva);

        $factMontantTotalTva = $facture -> getMontantTotalTva();
        $factMontantTotalTva += $montantTvaLivraison;
        $facture -> setMontantTotalTva($factMontantTotalTva);        
        
        $factMontantTotal = $facture -> getMontantTotal();
        $factMontantTotal += $montantTotalLivraison;
        $facture -> setMontantTotal($factMontantTotal);       
       
        // insertion dans la base de données
        $entityManager -> persist($facture);
        $entityManager -> flush(); 

        // 2) ENVOI MAIL DE CONFIRMATION AVEC PDF EN ANNEXE

        // envoie d'un mail de confirmation de l'achat à l'utilisateur connecté
        // appel à la fonction qui traite toutes les informations pour les afficher par aprés dans le Mail comme résumé
        $tabInfos = $this->infoArticlePanier($panier, $poidsTotal, $entityManager, $request);

        // création PDF pour l'annexe
        // Configuration des options
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'AvenirNext LT Pro');

        // Instanciation Dompdf avec les options
        $dompdf = new Dompdf($pdfOptions);

        // Récupération du HTML généré dans un fichier TWIG
        $html = $this->renderView('emails/facturePDF.html.twig', [
            'utilisateur' => $this -> getUser(),
            'facture' => $facture,
            'infosPanier' => $tabInfos[0],
            'total' => $tabInfos[1],
            'fraisLivraison' => $tabInfos[2],
            'fraisTVALivraison' => $tabInfos[3],
            'fraisTotalLivraison' => $tabInfos[4]
        ]);

        // Chargement HTML vers Dompdf
        $dompdf->loadHtml($html);

        // Définition taille
        $dompdf->setPaper('A4', 'portrait');

        // Render le HTML comme PDF
        $dompdf->render();

        // Output et attribution à la facture dans la base de données
        $output = $dompdf->output();

        //sujet à traduire
        $messageSubject = $translator -> trans('Zahlungsbestätigung');  

        // pour les factures le PDF va recevoir un nom unique défini par moi-même
        $facture -> setDocumentPDF($messageSubject.'-'.$facture -> getId().'.pdf');
        // insertion dans la base de données
        $entityManager -> persist($facture);
        $entityManager -> flush();    
        
        // Définiton direction public
        $publicDirectory = $this->getParameter('kernel.project_dir') . '\public\uploads\facturePDF';
        $pdfFilePath =  $publicDirectory.'\\'.$messageSubject.'-'.$facture -> getId().'.pdf';        
        // Enregistrement du PDF sur le chemin souhaité
        file_put_contents($pdfFilePath, $output);

        
        //e-mail vers utilisateur
        $email = (new TemplatedEmail())
        ->from('alain_niessen@hotmail.com') //de qui
        ->to(new Address($this -> getUser() -> getEmail())) //vers adresse mail du utilisateur
        ->subject($messageSubject) //sujet
        ->attachFromPath($pdfFilePath)
        ->htmlTemplate('emails/confirmationAchat.html.twig') //création template email confirmationAchat
        ->context([
            //passage des informations au template twig (token)
            'nom' => $this -> getUser() -> getPrenom(),
            'infosPanier' => $tabInfos[0],
            'total' => $tabInfos[1],
            'fraisLivraison' => $tabInfos[2],
            'fraisTVALivraison' => $tabInfos[3],
            'fraisTotalLivraison' => $tabInfos[4]          
        ]);
        // envoi du mail
        $mailer -> send($email);  

        //e-mail vers soap-opera
        $email2 = (new TemplatedEmail())
        ->from('alain_niessen@hotmail.com') //de qui
        ->to('julialeohoelscher@hotmail.com') //vers adresse mail du utilisateur
        ->subject($messageSubject) //sujet
        ->attachFromPath($pdfFilePath)
        ->htmlTemplate('emails/confirmationAchat.html.twig') //création template email confirmationAchat
        ->context([
            //passage des informations au template twig (token)
            'nom' => $this -> getUser() -> getPrenom(),
            'infosPanier' => $tabInfos[0],
            'total' => $tabInfos[1],
            'fraisLivraison' => $tabInfos[2],
            'fraisTVALivraison' => $tabInfos[3],
            'fraisTotalLivraison' => $tabInfos[4]          
        ]);
        // envoi du mail
        $mailer -> send($email2);  

        // reset du panier et nombre total des articles dans le panier
        $session -> set('panier', []);
        $session -> set('nombreArticles', 0);

        // ajout d'un message de réussite
        $message = $translator -> trans('Vielen Dank! Deine Bezahlung ist bestätigt!');
        $this -> addFlash('success', $message);

        return $this->redirectToRoute('home');
    }

    //----------------------------------------------
    // ROUTE PAIEMENT PAS REUSSI
    //----------------------------------------------
    /**
     * @Route("/cancel", name="cancel")
     */
    public function cancel(TranslatorInterface $translator): Response
    {        

        // ajout d'un message d'erreur
        $message = $translator -> trans('Irgendwas ist leider schiefgegangen! Bitte versuche es erneut oder nimm über das Kontaktformular mit uns Kontakt auf!');
        $this -> addFlash('error', $message);

        return $this->redirectToRoute('home');
    }

    //----------------------------------------------
    // FONCTION POUR CREATION PDF ET MAIL DE CONFIRMATION
    //----------------------------------------------
    function infoArticlePanier($panier, $poidsTotal, EntityManagerInterface $entityManager, Request $request)
    {
        // initialisation des variables
        $infosPanier = [];
        $prixTotal = 0;
        $infoComplete = [];

        // récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);    
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);

        // boucle sur le panier
        foreach($panier as $article ): 
            $articleID = key($article);
            $quantite = reset($article);
            if ($articleID && $quantite):
            
                // récupération de l'article via son ID via ArticleRepository
                $repositoryArticle = $entityManager -> getRepository(Article::class);
                $article = $repositoryArticle -> findOneBy(['id' => $articleID]);
                
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
                if($this -> getUser() -> getAdresseDeliver() -> getPays() === "DE" && $this -> getUser() -> getNumeroTVA()):
                    $prixTva = 0;
                else:
                    $prixTva = round(($prixHorsTva * $article -> getTauxTva()), 2);
                endif;
                
                $prixTotalArticle = $prixHorsTva + $prixTva;
                $prixTotalArticleQuantite = $prixTotalArticle * $quantite;            
                $prixTotal += $prixTotalArticleQuantite;

                // formats d'affichage
                $prixHorsTva = number_format($prixHorsTva, 2, ',', '.');
                $prixTva = number_format($prixTva, 2, ',', '.');
                $prixTotalArticle = number_format($prixTotalArticle, 2, ',', '.');
                $prixTotalArticleQuantite = number_format($prixTotalArticleQuantite, 2, ',', '.');           

                //récupération de la traduction de l'article via TraductionArticleRepository          
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
            endif;                      
        endforeach;

        // récupération du pays de l'adresse de livraison de l'utilisateur connecté pour calculer les frais de livraison
        $paysLivraison = $this -> getUser() -> getAdresseDeliver() -> getPays();
        // récupération du montant des frais de livraison dépendant du pays via LivraisonRepository
        $repositoryLivraison = $entityManager -> getRepository(Livraison::class); 
        $livraisons = $repositoryLivraison -> findBy(['pays' => $paysLivraison]);
        foreach($livraisons as $livraison):
            if($poidsTotal >= 2000):
                $liv = $repositoryLivraison -> findOneBy(['niveau' => 2]);
            else:
                $liv = $repositoryLivraison -> findOneBy(['niveau' => 1]);
            endif;
        endforeach;
        
        // frais de livraison
        $fraisLivraison = ($liv -> getMontantHorsTva()) / 100;

        // condition si l'utilisateur a activé le service de ramassage
        if($this->getUser()->getRamassage() == true):
            $fraisLivraison = 0;
            $montantTvaLivraison = 0;
            $montantTotalLivraison = 0;
        else:
            // condition si le prix total est supérieur de 100 Euro, pas de frais de livraison        
            if($prixTotal < 100):
                // Calculs
                $fraisLivraison = round($fraisLivraison, 2);
                // condition si utilisateur est une entreprise allemande avec numéro TVA
                if($this -> getUser() -> getAdresseDeliver() -> getPays() === "DE" && $this -> getUser() -> getNumeroTVA()):
                    $montantTvaLivraison = 0;
                else:
                    $montantTvaLivraison = round(($fraisLivraison * $livraison -> getTauxTva()), 2);
                endif;
                
                $montantTotalLivraison = $fraisLivraison + $montantTvaLivraison; 
            else:
                $fraisLivraison = 0;
                $montantTvaLivraison = 0;
                $montantTotalLivraison = 0;            
            endif;
        endif;


        $prixTotal += $montantTotalLivraison;

        // Affichage
        $fraisLivraison = number_format($fraisLivraison, 2, ',', '.');
        $montantTvaLivraison = number_format($montantTvaLivraison, 2, ',', '.');
        $montantTotalLivraison = number_format($montantTotalLivraison, 2, ',', '.');        
        $prixTotal = number_format($prixTotal, 2, ',', '.');
        

        $infoComplete[] = $infosPanier;
        $infoComplete[] = $prixTotal;
        $infoComplete[] = $fraisLivraison;
        $infoComplete[] = $montantTvaLivraison;
        $infoComplete[] = $montantTotalLivraison;
        
        return $infoComplete;
    }
}
