<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Article;
use App\Entity\TraductionArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    //----------------------------------------------
    // ROUTE PAGE ACCUEIL
    //----------------------------------------------
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {    
        // récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);     
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);
        
        // récupération 3 Bestseller sur base de nombre de ventes via ArticleRepository     
        $repositoryArticle = $entityManager -> getRepository(Article::class);     
        $tabBestseller = $repositoryArticle -> findArticlesBestseller(3);
        
        //récupération de la traduction des Bestseller dans la langue stockée dans la Session via TraductionArticleRepository
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticlesBest = $repositoryTraductionArticle -> findTraductionArticles($tabBestseller, $langue);

        // récupération 6 nouveautés sur base de la date de création via ArticleRepository   
        $repositoryArticle = $entityManager -> getRepository(Article::class); 
        $tabNewArticles = $repositoryArticle -> findNewArticles(6);
        
        //récupération de la traduction des nouveautés dans la langue stockée dans la Session via TraductionArticleRepository
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticlesNew = $repositoryTraductionArticle -> findTraductionArticles($tabNewArticles, $langue);


        return $this->render('home/index.html.twig', [
            'traductionArticlesBestseller' => $resultTraductionArticlesBest,
            'traductionArticlesNew' => $resultTraductionArticlesNew,
        ]);
    }
}
