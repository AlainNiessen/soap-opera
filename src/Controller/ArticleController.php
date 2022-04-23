<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    //----------------------------------------------
    // ROUTE RECHERCHE ARTICLES
    //----------------------------------------------
    /**
     * @Route("/article/recherche", name="article_recherche", methods={"POST", "GET"})
     */
    public function requestArticle(Request $request, EntityManagerInterface $entityManager): Response
    {
        //récupération des données rentrées dans le fomulaire
        $mots = $request -> request -> get('mots');

        //transform string en tableau
        $tabWords = explode(" ", trim($mots));

        //passage du tableau à la fonction de requete
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // fonction de requête sur base de données récupérées       
        $articles = $repositoryArticle -> findArticlesSearchBar();     

        dd($articles);

        return $this->render('article/list.html.twig', [
            'articles' => $articles
        ]);
    }
}
