<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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
}
