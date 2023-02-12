<?php

namespace App\Controller;

use DateTime;
use App\Entity\Langue;
use App\Entity\Article;
use App\Entity\Livraison;
use App\Entity\TraductionArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    //----------------------------------------------
    // ROUTE PANIER
    //----------------------------------------------
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session, EntityManagerInterface $entityManager, Request $request): Response
    {
        // récupération du panier avec toutes les informations + poids total pour le calcul des frais de livraison
        // si il y a un panier, c'est le premier paramétre, sinon c'est un tableau vide (deuxiéme paramétre)
        $panier = $session -> get('panier', []);
        
        //si le panier est vide => poids Total et nombres total Articles remis sur 0
        if(empty($panier)):
            $nombreArticles = 0;
            $poidsTotal = 0;
            $session -> set('nombresArticles', $nombreArticles);
            $session -> set('poidsTotal', $poidsTotal);
        endif;
        $poidsTotal = $session -> get('poidsTotal', 0);
        
        // appel à la fonction qui traite toutes les informations pour les afficher par aprés
        $tabInfos = $this -> infoArticlePanier($panier, $poidsTotal, $entityManager, $request);      
                    
        return $this->render('panier/index.html.twig', [
            'infosPanier' => $tabInfos[0],
            'total' => $tabInfos[1],
            'fraisLivraison' => $tabInfos[2],
            'fraisTVALivraison' => $tabInfos[3],
            'fraisTotalLivraison' => $tabInfos[4]
        ]);
    }

    //----------------------------------------------
    // ROUTE AJOUTER ARTICLE 
    //----------------------------------------------
    /**
     * @Route("/panier/add/{id}", name="add_panier")
     */
    public function add($id, SessionInterface $session, Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
    {
        // on récupére le panier actuel de la Session
        // si il y a un panier, c'est le premier paramétre, sinon c'est un tableau vide (deuxiéme paramétre)
        $panier = $session -> get('panier', []);

        //si le panier est vide => poids Total et nombres total Articles remis sur 0
        if(empty($panier)):
            $nombreArticles = 0;
            $poidsTotal = 0;
            $session -> set('nombresArticles', $nombreArticles);
            $session -> set('poidsTotal', $poidsTotal);
        endif;

        // récupération de l'URL pour rediriger par aprés sur différents routes (soit vers détial article soit vers profile utilisateur)
        $url = $request->headers->get('referer');        

        // on récupére le nombre des articles et le poids total dans le panier
        // si il y en a des articles, c'est le premier paramétre, sinon c'est 0 (deuxiéme paramétre)
        $nombreArticles = $session -> get('nombreArticles', 0);
        $poidsTotal = $session -> get('poidsTotal', 0);

        // récupération de l'article via son ID via ArticleRepository
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        $article = $repositoryArticle -> findOneBy(['id' => $id]);
        // récup du poids de l'article
        $poids = $article -> getPoids();             

        // on vérifie si l'article existe
        if($article):
            // on regarde si l'article avec son ID existe dans le panier
            // si il existe déjà, on incrémente en respectant le stock de l'article
            if(!empty($panier[$id][$id])):

                // quand le stock varie (actualisation par admin) => actualisation du nouveau stock
                $stockActuel = $article -> getStock();
                if($stockActuel != $panier[$id]['stockStart']):
                    $panier[$id]['stockStart'] = $stockActuel + $panier[$id][$id];
                endif;

                if($panier[$id][$id] < $panier[$id]['stockStart']):                   
                    $panier[$id][$id]++;                    
                    // actualisation du poids total
                    $poidsTotal += $poids;
                    // actualisation du stock dans la base de données                   
                    $article -> setStock($panier[$id]['stockStart'] - $panier[$id][$id]);
                    // insertion dans la base de données
                    $entityManager -> persist($article);
                    $entityManager -> flush();
                    // actualisation nombre articles
                    $nombreArticles++;                    
                elseif($panier[$id][$id] == $panier[$id]['stockStart']):
                    if($article -> getStock() > 0):                        
                        $panier[$id][$id]++;
                        // actualisation du poids total
                        $poidsTotal += $poids;
                        // actualisation du stock dans la base de données                     
                        $article -> setStock($panier[$id]['stockStart'] - $panier[$id][$id]);
                        // insertion dans la base de données
                        $entityManager -> persist($article);
                        $entityManager -> flush();
                        // actualisation nombre articles
                        $nombreArticles++;
                    endif;
                else:
                    $panier[$id][$id] = $session -> get('stockStart');                    
                endif;
            // si il n'existe pas, on le crée
            else:
                //récup du stock de départ
                $stockStart = $article -> getStock();
                // attribution des valeurs               
                $panier[$id][$id] = 1;
                $panier[$id]['stockStart'] = $stockStart;
                // actualisation du poids total et du stock
                $poidsTotal += $poids;                
                $article -> setStock($stockStart - 1);
                // insertion dans la base de données
                $entityManager -> persist($article);
                $entityManager -> flush();
                // actualisation nombre articles
                $nombreArticles++;
            endif;
            
            // on sauvgarde dans la Session
            $session -> set('panier', $panier);
            $session -> set('nombreArticles', $nombreArticles);
            $session -> set('poidsTotal', $poidsTotal);  

            // manipulation de la quantité de l'article via une requête AJAX
            if($request -> isXmlHttpRequest()) {
                // même traitement que sur la route "panier" pour actualiser le contenu sans rafraichissement de la page

                // récupération du panier avec toutes les informations
                // si il y a un panier, c'est le premier paramétre, sinon c'est un tableau vide (deuxiéme paramétre)
                $panier = $session -> get('panier', []);

                // appel à la fonction qui traite toutes les informations pour les afficher par aprés
                $tabInfos = $this -> infoArticlePanier($panier, $poidsTotal, $entityManager, $request); 
                
                return new JsonResponse([
                    'content' => $this -> renderView('panier/index.html.twig', [
                        'infosPanier' => $tabInfos[0],
                        'total' => $tabInfos[1],
                        'fraisLivraison' => $tabInfos[2],
                        'fraisTVALivraison' => $tabInfos[3],
                        'fraisTotalLivraison' => $tabInfos[4]
                    ])
                ]);
            }       
                    
            //ajout d'un message de réussite
            $message = $translator -> trans('Der Artikel wurde erfolgreich deinem Warenkorb hinzugefügt');
            $this -> addFlash('success', $message); 

            //redirect vers le détail de l'article ou vers le profile d'utilisateur
            if(str_contains($url, 'profile')):
                return $this->redirectToRoute('profile', [
                    'id' => $this -> getUser() -> getId()
                ]);
            elseif(str_contains($url, 'detail')):
                return $this->redirectToRoute('article_detail', [
                    'id' => $article->getId()
                ]);
            else:
                return $this->redirect($url);
            endif;
            
        else: 
            //ajout d'un message d'erreur que l'article n'existe pas
            $message = $translator -> trans('Ein Artikel mit dieser ID existiert nicht');
            $this -> addFlash('error', $message);

            //redirect vers le détail de l'article
            return $this->redirectToRoute('home'); 

        endif;
    }

    //----------------------------------------------
    // ROUTE RETIRER ARTICLE 
    //----------------------------------------------
    /**
     * @Route("/panier/remove/{id}", name="remove_panier")
     */
    public function remove($id, SessionInterface $session, Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
    {
        // on récupére le panier actuel de la Session
        // si il y a un panier, c'est le premier paramétre, sinon c'est un tableau vide (deuxiéme paramétre)
        $panier = $session -> get('panier', []);        

        // on récupére le nombre des articles et le poids total dans le panier
        // si il y en a des articles, c'est le premier paramétre, sinon c'est 0 (deuxiéme paramétre)
        $nombreArticles = $session -> get('nombreArticles', 0);
        $poidsTotal = $session -> get('poidsTotal', 0);

        // récupération de l'article via son ID
        // définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        $article = $repositoryArticle -> findOneBy(['id' => $id]); 
        // récup du poids de l'article        
        $poids = $article -> getPoids();          

        // on vérifie si l'article existe
        if($article):
            // on regarde si l'article avec son ID existe dans le panier
            // si il existe déjà, on diminue 
            if(!empty($panier[$id][$id])):
                //vérification supplémentaire si le nombre est plus grand que 1
                if($panier[$id][$id] > 1):
                    $panier[$id][$id]--;
                    // actualisation du poids total
                    $poidsTotal -= $poids;
                    // actualisation du stock dans la base de données
                    $article -> setStock($panier[$id]['stockStart'] - $panier[$id][$id]);
                    // insertion dans la base de données
                    $entityManager -> persist($article);
                    $entityManager -> flush();
                    // actualisation nombre articles
                    $nombreArticles--;
                else:
                    $panier[$id][$id] = 1;
                endif;
            endif;             

            // on sauvgarde dans la Session
            $session -> set('panier', $panier);
            $session -> set('nombreArticles', $nombreArticles);
            $session -> set('poidsTotal', $poidsTotal);

            // manipulation de la quantité de l'article via une requête AJAX
            if($request -> isXmlHttpRequest()) {
                // même traitement que sur la route "panier" pour actualiser le contenu sans rafraichissement de la page

                // récupération du panier avec toutes les informations
                // si il y a un panier, c'est le premier paramétre, sinon c'est un tableau vide (deuxiéme paramétre)
                $panier = $session -> get('panier', []);

                // appel à la fonction qui traite toutes les informations pour les afficher par aprés
                $tabInfos = $this -> infoArticlePanier($panier, $poidsTotal, $entityManager, $request); 

                return new JsonResponse([
                    'content' => $this -> renderView('panier/index.html.twig', [
                        'infosPanier' => $tabInfos[0],
                        'total' => $tabInfos[1],
                        'fraisLivraison' => $tabInfos[2],
                        'fraisTVALivraison' => $tabInfos[3],
                        'fraisTotalLivraison' => $tabInfos[4]
                    ])
                ]);
            }       
                    
            //ajout d'un message de réussite
            $message = $translator -> trans('Der Artikel wurde erfolgreich deinem Warenkorb abgezogen');
            $this -> addFlash('success', $message); 

            //redirect vers le détail de l'article
            return $this->redirectToRoute('article_detail', [
                'id' => $article->getId()
            ]);
            
        else: 
            //ajout d'un message d'erreur que l'article n'existe pas
            $message = $translator -> trans('Ein Artikel mit dieser ID existiert nicht');
            $this -> addFlash('error', $message);

            //redirect vers le détail de l'article
            return $this->redirectToRoute('home'); 

        endif;
    }  
    
    //----------------------------------------------
    // ROUTE SUPPRIMER ARTICLE 
    //----------------------------------------------
    /**
     * @Route("/panier/delete/{id}", name="delete_panier")
     */
    public function delete($id, SessionInterface $session, Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
    {
        // on récupére le panier actuel de la Session
        // si il y a un panier, c'est le premier paramétre, sinon c'est un tableau vide (deuxiéme paramétre)
        $panier = $session -> get('panier', []);        

        // on récupére le nombre des articles et le poids total dans le panier
        // si il y en a des articles, c'est le premier paramétre, sinon c'est 0 (deuxiéme paramétre)
        $nombreArticles = $session -> get('nombreArticles', 0);
        $poidsTotal = $session -> get('poidsTotal', 0);

        // récupération de l'article via son ID
        // définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        $article = $repositoryArticle -> findOneBy(['id' => $id]); 
        $poids = $article -> getPoids();          

        // on vérifie si l'article existe
        if($article):
            // on regarde si l'article avec son ID existe dans le panier
            // si le panier n'est pas vide => on le supprime
            if(!empty($panier[$id][$id])):
                // actualisation du poids total et nombre total
                $poidsTotal -= $panier[$id][$id] * $poids;
                $nombreArticles -= $panier[$id][$id];
                unset($panier[$id][$id]);                
                // actualisation du stock dans la base de données                
                $article -> setStock($panier[$id]['stockStart']);
                unset($panier[$id]['stockStart']);
                // insertion dans la base de données
                $entityManager -> persist($article);
                $entityManager -> flush();                
            endif;             

            // on sauvgarde dans la Session
            $session -> set('panier', $panier);
            $session -> set('nombreArticles', $nombreArticles); 
            $session -> set('poidsTotal', $poidsTotal);             

            // récupération du panier avec toutes les informations
            // si il y a un panier, c'est le premier paramétre, sinon c'est un tableau vide (deuxiéme paramétre)
            $panier = $session -> get('panier', []);            

            // appel à la fonction qui traite toutes les informations pour les afficher par aprés
            $tabInfos = $this -> infoArticlePanier($panier, $poidsTotal, $entityManager, $request); 
                        
            return $this->render('panier/index.html.twig', [
                'infosPanier' => $tabInfos[0],
                'total' => $tabInfos[1],
                'fraisLivraison' => $tabInfos[2],
                'fraisTVALivraison' => $tabInfos[3],
                'fraisTotalLivraison' => $tabInfos[4]
            ]);            
        else: 
            //ajout d'un message d'erreur que l'article n'existe pas
            $message = $translator -> trans('Ein Artikel mit dieser ID existiert nicht');
            $this -> addFlash('error', $message);

            //redirect vers le détail de l'article
            return $this->redirectToRoute('home'); 

        endif;
    }   
    
    //----------------------------------------------
    // FONCTION CREATION PANIER
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
                    $prixNette = ($article -> getMontantHorsTva()) - $reduction;                
                else:
                    $prixNette = $article -> getMontantHorsTva();                    
                endif;

                // calculs sur base du prix nette
                $prixHorsTva = round($prixNette / 100, 2);
                // condition si utilisateur est une entreprise allemande avec numéro TVA
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