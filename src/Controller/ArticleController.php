<?php

namespace App\Controller;

use App\Entity\Beurre;
use App\Entity\Langue;
use App\Entity\Article;
use App\Entity\TraductionHuile;
use App\Entity\TraductionBeurre;
use App\Entity\TraductionHuileEssentiel;
use App\Entity\TraductionIngredientSupplementaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        
        // récupération des articles        
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // récupération des articles      
        $tabArticles = $repositoryArticle -> findArticlesSearchBar($tabWords);
        
        // récupération du nombre des articles
        $nombreArticles = count($tabArticles);

        // définition nombre des articles par page
        $limit = 6;
        
        //définition start and end pour le tableau à transférer pour la pagination
        $startCount = $interPag * $limit - $limit;

        if($interPag * $limit >= count($tabArticles)):
            $endCount = count($tabArticles);
        else:
            $endCount = $interPag * $limit;
        endif;

        //nombre de pages de résultat
        $nombreLiens = ceil($nombreArticles / $limit);
        //définition limite affichage pagination
        $limitPagination = $interPag + 2;      
      
        $pagination = array_slice($tabArticles, $startCount, $endCount);

        // si il s'agit d'une requête AJAX
        // re-rendering le contenu et la navigation sans rechargement du site
        if($request -> isXmlHttpRequest()) {
            return new JsonResponse([
                'content' => $this -> renderView('article/_articles.html.twig', [
                    'articles' => $pagination
                ]),
                'navigationBar' => $this -> renderView('article/_navigationBar.html.twig', [
                    'articles' => $pagination,
                    'nombreLiens' => $nombreLiens,
                    'pagBar'=> $interPag,
                    'limitPagination' => $limitPagination
                ])
            ]);
        }           
        
        return $this->render('article/list.html.twig', [
            'articles' => $pagination,
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
        
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // fonction de requête sur base de données récupérées       
        $articlesCat = $repositoryArticle -> findArticlesByCategory($id);        

        // récupération du nombre des articles
        $nombreArticles = count($articlesCat);

        // définition nombre des articles par page
        $limit = 6;
        
        //définition start and end pour le tableau à transférer pour la pagination
        $startCount = $interPag * $limit - $limit;

        if($interPag * $limit >= count($articlesCat)):
            $endCount = count($articlesCat);
        else:
            $endCount = $interPag * $limit;
        endif;

        //nombre de pages de résultat
        $nombreLiens = ceil($nombreArticles / $limit);
        //définition limite affichage pagination
        $limitPagination = $interPag + 2;      
      
        $pagination = array_slice($articlesCat, $startCount, $endCount);

        // si il s'agit d'une requête AJAX
        // re-rendering le contenu et la navigation sans rechargement du site
        if($request -> isXmlHttpRequest()) {
            return new JsonResponse([
                'content' => $this -> renderView('article/_articles.html.twig', [
                    'articles' => $pagination                    
                ]),
                'navigationCat' => $this -> renderView('article/_navigationCat.html.twig', [
                    'articles' => $pagination,
                    'nombreLiens' => $nombreLiens,
                    'pagCat'=> $interPag,
                    'limitPagination' => $limitPagination,
                    'id' => $id
                ])
            ]);
        }          

        return $this->render('article/list.html.twig', [
            'articles' => $pagination,
            'nombreLiens' => $nombreLiens,
            'pagCat'=> $interPag,
            'limitPagination' => $limitPagination,
            'id' => $id
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

        //récupération des ingrédients de l'article
        //1) beurre
        $beurres = $article-> getBeurre();
        $resultBeurres = [];
        //définition repository traduction beurre
        $repositoryTraductionBeurre = $entityManager -> getRepository(TraductionBeurre::class);
        // fonction de requête sur base de données récupérées 
        foreach($beurres as $beurre) {
            $resultBeurres[] = $repositoryTraductionBeurre -> findTraductionBeurre($beurre, $langue);
        }  
        
        //2) huiles
        $huiles = $article -> getHuile();
        $resultHuiles = [];
        //définition repository traduction huile
        $repositoryTraductionHuile = $entityManager -> getRepository(TraductionHuile::class);
        // fonction de requête sur base de données récupérées 
        foreach($huiles as $huile) {
            $resultHuiles[] = $repositoryTraductionHuile -> findTraductionHuile($huile, $langue);
        } 

        //3) huiles essentiels
        $huilesEss = $article -> getHuileEssentiell();
        $resultHuilesEss = [];
        //définition repository traduction huile essentiel
        $repositoryTraductionHuileEss = $entityManager -> getRepository(TraductionHuileEssentiel::class);
        // fonction de requête sur base de données récupérées 
        foreach($huilesEss as $huileEss) {
            $resultHuilesEss[] = $repositoryTraductionHuileEss -> findTraductionHuileEss($huileEss, $langue);
        } 

        //4) ingrédients supplémentaires
        $ingredientsSupp = $article -> getIngredientSupplementaire();
        $resultIngredientsSupp = [];
        //définition repository traduction huile essentiel
        $repositoryIngredientsSupp = $entityManager -> getRepository(TraductionIngredientSupplementaire::class);
        // fonction de requête sur base de données récupérées 
        foreach($ingredientsSupp as $ingredientSupp) {
            $resultIngredientsSupp[] = $repositoryIngredientsSupp -> findTraductionIngredientSupp($ingredientSupp, $langue);
        }         

        //calcul du prix
        $prixArticle = (($article -> getMontantHorsTva() + ($article -> getMontantHorsTva() * $article -> getTauxTva())) / 100);
        $prixArticle = number_format($prixArticle, 2, ',', '.').' €';
        //redirect vers le detail de l'article
        return $this->render('article/detail.html.twig', [
            'article' => $article,
            'prix' => $prixArticle,
            'beurres' => $resultBeurres,
            'huiles' => $resultHuiles,
            'huilesEss' => $resultHuilesEss,
            'ingredientsSupp' => $resultIngredientsSupp     
        ]);
    }
}
