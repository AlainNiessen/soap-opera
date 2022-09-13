<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Evaluation;
use App\Entity\Commentaire;
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
    public function requestArticleSearchBar($pagBar, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {   
        // récupération de la pagination en int
        $interPag = intval($pagBar);
                
        // check si la barre de recherche a été utilisé
        // si oui => 
        if(isset($_GET['mots'])):
            //récupération des données rentrées dans le fomulaire
            $mots = $request -> query -> get('mots');
            // transform string en tableau
            $tabWords = explode(" ", trim($mots));  
            // stockage du tableau dans la session
            $session = $request->getSession();
            $session -> set('tabWords', $tabWords);
        // si non (par exemple en utilisant la pagination) 
        else:
            // récupération du tableau stocké dans la Session
            $session = $request->getSession();
            $tabWords = $session -> get('tabWords');
        endif;        
        
        // s'il y a des mots rentrés
        if(!$tabWords[0] == ""):
           // récupération langue via LangueRepository
            $lang = $request-> getLocale();
            $repositoryLangue = $entityManager -> getRepository(Langue::class);     
            $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 
            
            // récupération des articles sur base des mots de clé via ArticleRepository        
            $repositoryArticle = $entityManager -> getRepository(Article::class);     
            $tabArticles = $repositoryArticle -> findArticlesSearchBar($tabWords);
       
            // préparation de la pagination
            // récupération du nombre des articles
            $nombreArticles = count($tabArticles);
            // définition nombre des articles par page
            $limit = 4;            
            // définition start and end pour le tableau à transférer pour la pagination
            $startCount = $interPag * $limit - $limit;
            
            // récupération de la traduction des articles basée sur la langue stockée dans la Session en respectant le début et la fin de la pagination
            $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);       
            $resultTraductionArticles = $repositoryTraductionArticle -> findTraductionArticles($tabArticles, $langue, $startCount, $limit);              

            // nombre de pages de résultat
            $nombreLiens = ceil($nombreArticles / $limit);
                    
            return $this->render('article/list.html.twig', [
                'traductionArticles' => $resultTraductionArticles,
                'nombreLiens' => $nombreLiens,
                'pagBar'=> $interPag
            ]);        
        // s'il n'y a pas des mots rentrés
        else:
            // ajout d'un message de warning
            $message = $translator -> trans('Es wurden keine Artikel unter diesen Kriterien gefunden.');
            $this -> addFlash('notice', $message);

            return $this->redirectToRoute('home');
        endif;
    }
    
    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES - PAR CATEGORIE
    //----------------------------------------------
    /**
     * @Route("/article/recherche/categorie-{id}/page={pagCat}", name="article_recherche_cat")
     */
    public function requestArticleCategory($id, $pagCat, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        // récupération de la pagination en int
        $interPag = intval($pagCat);

        // récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 
        
        // récupération des articles par categorie via ArticleRepository + ID de la catégorie (passée en URL)
        $repositoryArticle = $entityManager -> getRepository(Article::class);     
        $articlesCat = $repositoryArticle -> findArticlesByCategory($id); 
        
        // s'il y a des articles
        if($articlesCat):
            // préparation de la pagination
            // récupération du nombre des articles
            $nombreArticles = count($articlesCat);
            // définition nombre des articles par page
            $limit = 4;            
            // définition start and end pour le tableau à transférer pour la pagination
            $startCount = $interPag * $limit - $limit;

            // récupération de la traduction des articles basée sur la langue stockée dans la Session en respectant le début et la fin de la pagination
            $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
            $resultTraductionArticles = $repositoryTraductionArticle -> findTraductionArticles($articlesCat, $langue, $startCount, $limit);

            // nombre de pages de résultat
            $nombreLiens = ceil($nombreArticles / $limit);
                
            return $this->render('article/list.html.twig', [
                'traductionArticles' => $resultTraductionArticles,
                'nombreLiens' => $nombreLiens,
                'pagCat'=> $interPag,
                'id' => $id
            ]);
        // s'il n'y a pas des articles
        else:
            // ajout d'un message de warning
            $message = $translator -> trans('Unter dieser Kategorie gibt es zur Zeit keine Artikel.');
            $this -> addFlash('notice', $message);

            return $this->redirectToRoute('home');

        endif;
    }

    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES - ARTICLES EN PROMOTION
    //----------------------------------------------
    /**
     * @Route("/article/promotions/page={pagPromo}", name="article_recherche_promo")
     */
    public function requestArticlePromotion($pagPromo, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        // récupération de la pagination en int
        $interPag = intval($pagPromo);

        // récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);     
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 
        
        // récupération des articles en promotion via ArticleRepository
        $repositoryArticle = $entityManager -> getRepository(Article::class);      
        $articlesPromotions = $repositoryArticle -> findArticlesInPromotion(); 
        
        // récupération des catégories en promotion via CategorieRepository
        $repositoryCategorie = $entityManager -> getRepository(Categorie::class);      
        $categoriePromotions = $repositoryCategorie -> findcategorieInPromotion();  
        
        // création tableau avec tous les articles en promo
        $tabPromo = [];
        // push articles en promotion dans le tableau
        foreach($articlesPromotions as $articlesPromotion):
            array_push($tabPromo, $articlesPromotion);
        endforeach;
        // push articles de la categorie en promotion dans le tableau
        foreach($categoriePromotions as $categoriePromotion):
            $articles = $categoriePromotion -> getArticles();
            foreach($articles as $article):
                array_push($tabPromo, $article);
            endforeach;
        endforeach;   
        
        // s'il y des articles en promotion
        if($tabPromo):
            // préparation de la pagination
            // récupération du nombre des articles
            $nombreArticles = count($tabPromo);
            // définition nombre des articles par page
            $limit = 4;            
            // définition start and end pour le tableau à transférer pour la pagination
            $startCount = $interPag * $limit - $limit;

            // récupération de la traduction des articles basée sur la langue stockée dans la Session en respectant le début et la fin de la pagination
            $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
            $resultTraductionArticles = $repositoryTraductionArticle -> findTraductionArticles($tabPromo, $langue, $startCount, $limit);

            //nombre de pages de résultat
            $nombreLiens = ceil($nombreArticles / $limit);
            
            return $this->render('article/list.html.twig', [
                'traductionArticles' => $resultTraductionArticles,
                'nombreLiens' => $nombreLiens,
                'pagPromo'=> $interPag
            ]);
        // s'il n'y a pas des articles en promotion
        else:
            // ajout d'un message de warning
            $message = $translator -> trans('Zur Zeit gibt es keine Artikel in Sonderangebot.');
            $this -> addFlash('notice', $message);

            return $this->redirectToRoute('home');
        endif;

    }

    //----------------------------------------------
    // ROUTE DETAIL ARTICLE
    //----------------------------------------------
    /**
     * @Route("/article/detail/{id}", name="article_detail")
     */
    public function requestArticleDetail(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {   
        // récupération de l'article via la requété automatique et son ID passé dans la route 
        
        // récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);     
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]); 

        // récupération de la traduction des informations sur article basée sur la langue stockée dans la Session via TraductionArticleRepository
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticle = $repositoryTraductionArticle -> findTraductionArticle($article -> getId(), $langue);

        //récupération de la traduction de la categorie de l'article basée sur la langue stockée dans la Session via TraductionCategorieRepository
        $categorieArticle = $article -> getCategorie();
        $repositoryTraductionCategorie = $entityManager -> getRepository(TraductionCategorie::class);
        $resultTraductionCategorie = $repositoryTraductionCategorie -> findTraductionCategorie($categorieArticle -> getId(), $langue);        

        //récupération des ingrédients de l'article
        //1) beurre
        $beurres = $article-> getBeurre();        
        if(!$beurres -> isEmpty()):
            //récupération de la traduction de la beurre basée sur la langue stockée dans la Session via TraductionBeurreRepository
            $repositoryTraductionBeurre = $entityManager -> getRepository(TraductionBeurre::class);
            $resultTraductionBeurres = $repositoryTraductionBeurre -> findTraductionBeurre($beurres, $langue);
        else:
            $resultTraductionBeurres = [];
        endif;           
        
        //2) huiles
        $huiles = $article -> getHuile();
        if(!$huiles -> isEmpty()):
            //récupération de la traduction de l'huile basée sur la langue stockée dans la Session via TraductionHuileRepository
            $repositoryTraductionHuile = $entityManager -> getRepository(TraductionHuile::class);
            $resultTraductionHuiles = $repositoryTraductionHuile -> findTraductionHuile($huiles, $langue);
        else:
            $resultTraductionHuiles = [];
        endif;        

        //3) huiles essentiels
        $huilesEss = $article -> getHuileEssentiell();
        if(!$huilesEss -> isEmpty()):
            //récupération de la traduction de l'huile essentiel basée sur la langue stockée dans la Session via TraductionHuileEssentielRepository
            $repositoryTraductionHuileEss = $entityManager -> getRepository(TraductionHuileEssentiel::class);
            $resultTraductionHuilesEss = $repositoryTraductionHuileEss -> findTraductionHuileEss($huilesEss, $langue);    
        else:
            $resultTraductionHuilesEss = [];
        endif;    

        //4) ingrédients supplémentaires
        $ingredientsSupp = $article -> getIngredientSupplementaire();
        if(!$ingredientsSupp -> isEmpty()):
            //récupération de la traduction de l'ingrédient supplémentaire basée sur la langue stockée dans la Session via TraductionIngredientSupplementaireRepository
            $repositoryIngredientsSupp = $entityManager -> getRepository(TraductionIngredientSupplementaire::class);
            // fonction de requête sur base de données récupérées 
            $resultTraductionIngredientsSupp = $repositoryIngredientsSupp -> findTraductionIngredientSupp($ingredientsSupp, $langue);
        else:
            $resultTraductionIngredientsSupp = [];
        endif;              

        // récupération + calcul + affichage (number_format) des montants
        $prixArticle = (($article -> getMontantHorsTva() + ($article -> getMontantHorsTva() * $article -> getTauxTva())) / 100);
        $prixArticle = number_format($prixArticle, 2, ',', '.').' €';
        $prixArticlePromo = 0;
        // si il y a une promotion
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
        // récupération du nombre des évaluations sur un article et le total du nombre des étoiles pour l'article
        $repositoryEvaluations = $entityManager -> getRepository(Evaluation::class);
        $nombreEvaluations = $repositoryEvaluations -> countEvaluations($article);
        $nombreEtoiles = $repositoryEvaluations -> countStars($article);
        // calcul de la moyenne des étoiles pour l'article
        if($nombreEvaluations != 0):
            $notationMoyenne = round($nombreEtoiles / $nombreEvaluations, 1);
        else:
            $notationMoyenne = 0;
        endif;        
               
        // récupération des commentaires validés par l'administrateur (publication = true) via CommentaireRepository
        $repositoryCommentaires = $entityManager -> getRepository(Commentaire::class);
        $resultCommentaires = $repositoryCommentaires -> findCommentaires($article); 
        
        //redirect vers le detail de l'article avec toutes les informations récupéréés
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
        // vérification s'il y a un commentaire passé via le formulaire
        if(isset($_POST['commentaire']) && !empty($_POST['commentaire'])):
            // création nouveau commentaire
            $commentaire = new Commentaire();
            $commentaire -> setDateCommentaire(new \Datetime());
            $commentaire -> setPublication(false); // va être publié après vérification de l'administrateur
            $commentaire -> setArticle($article);
            $commentaire -> setUtilisateur($this->getUser());
            $commentaire -> setContenu($_POST['commentaire']);

            // insertion dans la base de données
            $entityManager -> persist($commentaire);
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
        // contrôle si l'utilisateur actuellement connecté a déjà évalué l'atricle en question via EvaluationRepository
        $repositoryEvaluation = $entityManager -> getRepository(Evaluation::class);
        $resultEvaluation = $repositoryEvaluation -> findBy(['article' => $article, 'utilisateur' => $this->getUser()]);
        
        // s'il n'y a pas d'évaluation fait par l'utilisateur sur l'article en question
        if(empty($resultEvaluation)):
            //Création nouvelle évaluation
            $evaluation = new Evaluation();
            $evaluation -> setNombreEtoiles($_POST['note']);
            $evaluation -> setArticle($article); 
            $evaluation -> setUtilisateur($this->getUser());           

            // insertion dans la base de données
            $entityManager -> persist($evaluation);
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
        $favoris = $this->getUser()->getArticles();

        // check si l'article en question fait déjà partie des favoris de l'utilisateur
        // si non => création nouveau favori
        if(!$favoris->contains($article)):
            // ajout favori à l'utilisateur
            $this->getUser()->addArticle($article);

            // insertion dans la base de données
            $entityManager -> persist($this->getUser());
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
