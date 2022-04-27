<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;




class ArticleController extends AbstractController
{
    //stockage du tableau avec les valeurs de recherche dans la Session
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES - BARRE DE RECHERCHE
    //----------------------------------------------
    /**
     * @Route("/article/recherche/{pag}", name="article_recherche", methods={"POST", "GET"})
     */
    public function requestArticleSearchBar($pag, Request $request, EntityManagerInterface $entityManager): Response
    {   
        $interPag = intval($pag);     
        //récupération des données rentrées dans le fomulaire
        $mots = $request -> request -> get('mots');        

        //transform string en tableau
        $tabWords = explode(" ", trim($mots));               

        // récupération des articles
        
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // récupération des articles      
        $tabArticles = $repositoryArticle -> findArticlesSearchBar($tabWords); 

        
        // récupération du nombre des articles
        $nombreArticles = count($tabArticles);
        // dd($nombreArticles);
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
           
        
        return $this->render('article/list.html.twig', [
            'articles' => $pagination,
            'nombreLiens' => $nombreLiens,
            'pag'=> $interPag,
            'limitPagination' => $limitPagination
        ]);
    }
    
    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES - PAR CATEGORIE
    //----------------------------------------------
    /**
     * @Route("/article/recherche/categorie-{id}/", name="article_recherche_cat")
     */
    public function requestArticleCategory($id, Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // fonction de requête sur base de données récupérées       
        $articlesCat = $repositoryArticle -> findArticlesByCategory($id);
     

        //installation d'un système de pagination
        $articlesCatPag = $paginator->paginate(
            $articlesCat,
            $request->query->getInt('page', 1),
            6
        ); 
        // configuration du système de pagination (template)  
        $articlesCatPag->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        
        

        return $this->render('article/list.html.twig', [
            'articles' => $articlesCatPag
        ]);
    }
}
