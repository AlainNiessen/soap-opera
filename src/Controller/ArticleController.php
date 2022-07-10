<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Evaluation;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use App\Entity\TraductionHuile;
use App\Entity\TraductionBeurre;
use App\Entity\TraductionArticle;
use App\Entity\TraductionCategorie;
use App\Entity\TraductionHuileEssentiel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TraductionIngredientSupplementaire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    
    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES - BARRE DE RECHERCHE
    //----------------------------------------------
    /**
     * @Route("/article/recherche/page={pagBar}", name="article_recherche", methods={"GET", "POST"})
     */
    public function requestArticleSearchBar($pagBar, Request $request, EntityManagerInterface $entityManager): Response
    {   
        //récupération de la pagination
        $interPag = intval($pagBar);
        
        //check si la barre de recherche a été utilisé
        // si oui => 
        if(isset($_GET['mots'])):
            //récupération des données rentrées dans le fomulaire
            $mots = $request -> query -> get('mots');
            //transform string en tableau
            $tabWords = explode(" ", trim($mots));  
            //stockage du tableau dans la session
            $session = $request->getSession();
            $session -> set('tabWords', $tabWords);
        // si non (par exemple en utilisant la pagination) =>
        else:
            //récupération du tableau stocké dans la Session
            $session = $request->getSession();
            $tabWords = $session -> get('tabWords');
        endif;
        
        //récupération langue
        $lang = $request-> getLocale();
        //définition repository langue
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 
        
        // récupération des articles        
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // récupération des articles      
        $tabArticles = $repositoryArticle -> findArticlesSearchBar($tabWords);

        //récupération des informations sur les articles dans la langue
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticles = $repositoryTraductionArticle -> findTraductionArticles($tabArticles, $langue);

          
        // récupération du nombre des articles
        $nombreArticles = count($resultTraductionArticles);

        // définition nombre des articles par page
        $limit = 6;
        
        //définition start and end pour le tableau à transférer pour la pagination
        $startCount = $interPag * $limit - $limit;

        if($interPag * $limit >= count($resultTraductionArticles)):
            $endCount = count($resultTraductionArticles);
        else:
            $endCount = $interPag * $limit;
        endif;

        //nombre de pages de résultat
        $nombreLiens = ceil($nombreArticles / $limit);
        //définition limite affichage pagination
        $limitPagination = $interPag + 2;      
      
        $pagination = array_slice($resultTraductionArticles, $startCount, $endCount);      
            
        
        return $this->render('article/list.html.twig', [
            'traductionArticles' => $pagination,
            'nombreLiens' => $nombreLiens,
            'pagBar'=> $interPag,
            'limitPagination' => $limitPagination
        ]);
    }
    
    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES - PAR CATEGORIE
    //----------------------------------------------
    /**
     * @Route("/article/recherche/categorie-{id}/page={pagCat}", name="article_recherche_cat")
     */
    public function requestArticleCategory($id, $pagCat, Request $request, EntityManagerInterface $entityManager): Response
    {
        //récupération de la pagination
        $interPag = intval($pagCat);

        //récupération langue
        $lang = $request-> getLocale();
        //définition repository beurre
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 
        
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // fonction de requête sur base de données récupérées       
        $articlesCat = $repositoryArticle -> findArticlesByCategory($id);   
        
        //récupération des informations sur les articles dans la langue
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticles = $repositoryTraductionArticle -> findTraductionArticles($articlesCat, $langue);

        // récupération du nombre des articles
        $nombreArticles = count($resultTraductionArticles);

        // définition nombre des articles par page
        $limit = 6;
        
        //définition start and end pour le tableau à transférer pour la pagination
        $startCount = $interPag * $limit - $limit;

        if($interPag * $limit >= count($resultTraductionArticles)):
            $endCount = count($resultTraductionArticles);
        else:
            $endCount = $interPag * $limit;
        endif;

        //nombre de pages de résultat
        $nombreLiens = ceil($nombreArticles / $limit);
        //définition limite affichage pagination
        $limitPagination = $interPag + 2;      
      
        $pagination = array_slice($resultTraductionArticles, $startCount, $endCount);

        // si il s'agit d'une requête AJAX
        // re-rendering le contenu et la navigation sans rechargement du site
        if($request -> isXmlHttpRequest()) {
            return new JsonResponse([
                'content' => $this -> renderView('article/_articles.html.twig', [
                    'traductionArticles' => $pagination,                
                ]),
                'navigationCat' => $this -> renderView('article/_navigationCat.html.twig', [
                    'traductionArticles' => $pagination,
                    'nombreLiens' => $nombreLiens,
                    'pagCat'=> $interPag,
                    'limitPagination' => $limitPagination,
                    'id' => $id
                ])
            ]);
        }          

        return $this->render('article/list.html.twig', [
            'traductionArticles' => $pagination,
            'nombreLiens' => $nombreLiens,
            'pagCat'=> $interPag,
            'limitPagination' => $limitPagination,
            'id' => $id
        ]);
    }

    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES - ARTICLES EN PROMOTION
    //----------------------------------------------
    /**
     * @Route("/article/promotions/page={pagPromo}", name="article_recherche_promo")
     */
    public function requestArticlePromotion($pagPromo, Request $request, EntityManagerInterface $entityManager): Response
    {
        //récupération de la pagination
        $interPag = intval($pagPromo);

        //récupération langue
        $lang = $request-> getLocale();
        //définition repository beurre
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 
        
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // fonction de requête sur base de données récupérées       
        $articlesPromotions = $repositoryArticle -> findArticlesInPromotion();  
        //définition repository categorie
        $repositoryCategorie = $entityManager -> getRepository(Categorie::class);
        // fonction de requête sur base de données récupérées       
        $categoriePromotions = $repositoryCategorie -> findcategorieInPromotion();  
        
        //création tableau avec tous les articles en promo
        $tabPromo = [];
        //push articles en promotion dans le tableau
        foreach($articlesPromotions as $articlesPromotion):
            array_push($tabPromo, $articlesPromotion);
        endforeach;
        //push articles de la categorie en promotion dans le tableau
        foreach($categoriePromotions as $categoriePromotion):
            $articles = $categoriePromotion -> getArticles();
            foreach($articles as $article):
                array_push($tabPromo, $article);
            endforeach;
        endforeach;
        
        
        //récupération des informations sur les articles dans la langue
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticles = $repositoryTraductionArticle -> findTraductionArticles($tabPromo, $langue);

        // récupération du nombre des articles
        $nombreArticles = count($resultTraductionArticles);

        // définition nombre des articles par page
        $limit = 6;
        
        //définition start and end pour le tableau à transférer pour la pagination
        $startCount = $interPag * $limit - $limit;

        if($interPag * $limit >= count($resultTraductionArticles)):
            $endCount = count($resultTraductionArticles);
        else:
            $endCount = $interPag * $limit;
        endif;

        //nombre de pages de résultat
        $nombreLiens = ceil($nombreArticles / $limit);
        //définition limite affichage pagination
        $limitPagination = $interPag + 2;      
      
        $pagination = array_slice($resultTraductionArticles, $startCount, $endCount);

        // si il s'agit d'une requête AJAX
        // re-rendering le contenu et la navigation sans rechargement du site
        if($request -> isXmlHttpRequest()) {
            return new JsonResponse([
                'content' => $this -> renderView('article/_articles.html.twig', [
                    'traductionArticles' => $pagination                    
                ]),
                'navigationPromo' => $this -> renderView('article/_navigationPromo.html.twig', [
                    'traductionArticles' => $pagination,
                    'nombreLiens' => $nombreLiens,
                    'pagPromo'=> $interPag,
                    'limitPagination' => $limitPagination
                ])
            ]);
        }          

        return $this->render('article/list.html.twig', [
            'traductionArticles' => $pagination,
            'nombreLiens' => $nombreLiens,
            'pagPromo'=> $interPag,
            'limitPagination' => $limitPagination
        ]);
    }

    //----------------------------------------------
    // ROUTE DETAIL ARTICLE
    //----------------------------------------------
    /**
     * @Route("/article/detail/{id}", name="article_detail")
     */
    public function requestArticleDetail(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {   
        //récupération de l'article via la requété automatique et son ID passé dans la route 
        
        //récupération langue
        $lang = $request-> getLocale();
        //définition repository beurre
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 

        //récupération des informations sur article dans la langue
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticle = $repositoryTraductionArticle -> findTraductionArticle($article -> getId(), $langue);

        //récupération categorie de l'article dans la langue
        $categorieArticle = $article -> getCategorie();
        $repositoryTraductionCategorie = $entityManager -> getRepository(TraductionCategorie::class);
        $resultTraductionCategorie = $repositoryTraductionCategorie -> findTraductionCategorie($categorieArticle -> getId(), $langue);
        

        //récupération des ingrédients de l'article
        //1) beurre
        $beurres = $article-> getBeurre();        
        if(!$beurres -> isEmpty()):
            //définition repository traduction beurre
            $repositoryTraductionBeurre = $entityManager -> getRepository(TraductionBeurre::class);
            // fonction de requête sur base de données récupérées 
            $resultTraductionBeurres = $repositoryTraductionBeurre -> findTraductionBeurre($beurres, $langue);
        else:
            $resultTraductionBeurres = [];
        endif;  
         
        
        //2) huiles
        $huiles = $article -> getHuile();
        if(!$huiles -> isEmpty()):
            //définition repository traduction huile
            $repositoryTraductionHuile = $entityManager -> getRepository(TraductionHuile::class);
            // fonction de requête sur base de données récupérées 
            $resultTraductionHuiles = $repositoryTraductionHuile -> findTraductionHuile($huiles, $langue);
        else:
            $resultTraductionHuiles = [];
        endif;        

        //3) huiles essentiels
        $huilesEss = $article -> getHuileEssentiell();
        if(!$huilesEss -> isEmpty()):
            //définition repository traduction huile essentiel
            $repositoryTraductionHuileEss = $entityManager -> getRepository(TraductionHuileEssentiel::class);
            // fonction de requête sur base de données récupérées 
            $resultTraductionHuilesEss = $repositoryTraductionHuileEss -> findTraductionHuileEss($huilesEss, $langue);    
        else:
            $resultTraductionHuilesEss = [];
        endif;    

        //4) ingrédients supplémentaires
        $ingredientsSupp = $article -> getIngredientSupplementaire();
        if(!$ingredientsSupp -> isEmpty()):
            //définition repository traduction huile essentiel
            $repositoryIngredientsSupp = $entityManager -> getRepository(TraductionIngredientSupplementaire::class);
            // fonction de requête sur base de données récupérées 
            $resultTraductionIngredientsSupp = $repositoryIngredientsSupp -> findTraductionIngredientSupp($ingredientsSupp, $langue);
        else:
            $resultTraductionIngredientsSupp = [];
        endif;              

        //calcul du prix
        $prixArticle = (($article -> getMontantHorsTva() + ($article -> getMontantHorsTva() * $article -> getTauxTva())) / 100);
        $prixArticle = number_format($prixArticle, 2, ',', '.').' €';
        $prixArticlePromo = 0;
        // si il y a une réduction sur le prix
        if($article -> getPromotion() || $article -> getCategorie() -> getPromotion()):
            if($article -> getPromotion()):
                $reduction = $article -> getMontantHorsTva() * $article -> getPromotion() -> getPourcentage();
            elseif($article -> getCategorie() -> getPromotion()):
                $reduction = $article -> getMontantHorsTva() * $article -> getCategorie() -> getPromotion() -> getPourcentage();
            endif;
            $prixArticlePromo = ((($article -> getMontantHorsTva() - $reduction) + (($article -> getMontantHorsTva() - $reduction) * $article -> getTauxTva())) / 100);
            $prixArticlePromo = number_format($prixArticlePromo, 2, ',', '.').' €';
        endif; 

        // récupération des évaluations sur l'article en question
        // définition repository evaluation
        $repositoryEvaluations = $entityManager -> getRepository(Evaluation::class);
        // récupération du nombre des évaluations sur l'article
        $nombreEvaluations = $repositoryEvaluations -> countEvaluations($article);
        // récupération nombre total des étoiles sur l'article
        $nombreEtoiles = $repositoryEvaluations -> countStars($article);
        // définition notations moyenne
        if($nombreEvaluations != 0):
            $notationMoyenne = round($nombreEtoiles / $nombreEvaluations, 1);
        else:
            $notationMoyenne = 0;
        endif;
        
               
        // récupération des commentaires validés par l'administrateur (publication = true)
        // définition repository commentaires
        $repositoryCommentaires = $entityManager -> getRepository(Commentaire::class);
        // récupération des commentaires sur l'article 
        $resultCommentaires = $repositoryCommentaires -> findCommentaires($article); 
            


        //redirect vers le detail de l'article
        return $this->render('article/detail.html.twig', [
            'traductionArticle' => $resultTraductionArticle,
            'traductionCategorie' => $resultTraductionCategorie,
            'prix' => $prixArticle,
            'prixPromo' => $prixArticlePromo,
            'traductionBeurres' => $resultTraductionBeurres,
            'traductionHuiles' => $resultTraductionHuiles,
            'traductionHuilesEss' => $resultTraductionHuilesEss,
            'traductionIngredientsSupp' => $resultTraductionIngredientsSupp ,
            'commentaires' => $resultCommentaires,
            'nombreEvaluations' => $nombreEvaluations,
            'notationMoyenne' => $notationMoyenne  
        ]);
    }

    //----------------------------------------------
    // ROUTE COMMENTAIRE ARTICLE
    //----------------------------------------------
    /**
     * @Route("/article/commentaire/{id}", name="article_commentaire", methods="post|get")
     */
    public function commentaire(Article $article, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        if(isset($_POST['commentaire']) && !empty($_POST['commentaire'])):

            $commentaire = new Commentaire();
            $commentaire -> setDateCommentaire(new \Datetime());
            $commentaire -> setPublication(false); // va être publié après vérification de l'administrateur
            $commentaire -> setArticle($article);
            $commentaire -> setUtilisateur($this->getUser());
            $commentaire -> setContenu($_POST['commentaire']);

            //préparation insertion dans la BD
            $entityManager -> persist($commentaire);
            //insertion BD
            $entityManager -> flush();

            //ajout d'un message de réussite
            $message = $translator -> trans('Vielen Dank für deinen Kommentar. Nach Überprüfung wird dieser in Kürze freigeschaltet');
            $this -> addFlash('success', $message); 
        else: 
            //ajout d'un message de notice
            $message = $translator -> trans('Du hast keinen Kommentar abgegeben.');
            $this -> addFlash('notice', $message);
        endif;
        
        //redirect vers le détail de l'article
        return $this->redirectToRoute('article_detail', [
            'id' => $article->getId()
        ]); 
    }
    //----------------------------------------------
    // ROUTE EVALUATION ARTICLE
    //----------------------------------------------
    /**
     * @Route("/article/evaluation/{id}", name="article_evaluation", methods="post|get")
     */
    public function evaluation(Article $article, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        // contrôle si l'utilisateur actuellement connecté a déjà évalué l'atricle en question
        // définition repository evaluation
        $repositoryEvaluation = $entityManager -> getRepository(Evaluation::class);
        // fonction de requête sur base de données récupérées 
        $resultEvaluation = $repositoryEvaluation -> findBy(['article' => $article, 'utilisateur' => $this->getUser()]);
        
        if(empty($resultEvaluation)):
            //Création nouvelle évaluation
            $evaluation = new Evaluation();
            $evaluation -> setNombreEtoiles($_POST['note']);
            $evaluation -> setArticle($article); 
            $evaluation -> setUtilisateur($this->getUser());           

            //préparation insertion dans la BD
            $entityManager -> persist($evaluation);
            //insertion BD
            $entityManager -> flush();

            //ajout d'un message de réussite
            $message = $translator -> trans('Vielen Dank für deine Bewertung. Sie wird bei der Berrechnung der Durchschnittsbewertung einfliessen');
            $this -> addFlash('success', $message); 
        else:
            //ajout d'un message de notice
            $message = $translator -> trans('Für diesen Artikel hast du schon eine Bewertung abgegeben.');
            $this -> addFlash('notice', $message);

        endif;
        
        //redirect vers le détail de l'article
        return $this->redirectToRoute('article_detail', [
            'id' => $article->getId()
        ]); 
    }
    //----------------------------------------------
    // ROUTE ARTICLE COMME FAVORI
    //----------------------------------------------
    /**
     * @Route("/article/favori/{id}", name="article_favori")
     */
    public function favori(Article $article, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        // contrôle si l'utilisateur connecté a déjà ajouté cet article comme favori
        // récupération des favoris de l'utilisateur actuellement connecté
        $favoris = $this->getUser()->getArticles();
        // check si l'article en question fait déjà partie des favoris de l'utilisateur
        // si non => création nouveau favori
        if(!$favoris->contains($article)):
            $this->getUser()->addArticle($article);
            //préparation insertion dans la BD
            $entityManager -> persist($this->getUser());
            //insertion BD
            $entityManager -> flush();
            //ajout d'un message de réussite (avec paramétre nom de l'article)
            $message = $translator -> trans('Du hast diesen Artikel erfolgreich als Favorit hinzugefügt!');
            $this -> addFlash('success', $message); 
        // so oui => message de notice que cet article a été déjà choisi comme favori
        else:
            //ajout d'un message de réussite (avec paramétre nom de l'article)
            $message = $translator -> trans('Diesen Artikel hast du schon als Favorit gewählt');
            $this -> addFlash('notice', $message); 
        endif;
        
        //redirect vers le détail de l'article
        return $this->redirectToRoute('article_detail', [
            'id' => $article->getId()
        ]); 
    }
}
