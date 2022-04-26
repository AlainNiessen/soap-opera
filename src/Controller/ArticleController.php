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

class ArticleController extends AbstractController
{
    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES - BARRE DE RECHERCHE
    //----------------------------------------------
    /**
     * @Route("/article/recherche", name="article_recherche", methods={"POST", "GET"})
     */
    public function requestArticleSearchBar(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {       
        //récupération des données rentrées dans le fomulaire
        $mots = $request -> request -> get('mots');

        //transform string en tableau
        $tabWords = explode(" ", trim($mots));

        //passage du tableau à la fonction de requete
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // fonction de requête sur base de données récupérées       
        $queryArticles = $repositoryArticle -> findArticlesSearchBar($tabWords);

      

        //installation d'un système de pagination
        $articlesSearchPag = $paginator->paginate(
            $queryArticles,
            $request->query->getInt('page', 1),
            6
        ); 
                
        // configuration du système de pagination (template)  
        $articlesSearchPag->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        
        
        return $this->render('article/list.html.twig', [
            'articles' => $articlesSearchPag
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
