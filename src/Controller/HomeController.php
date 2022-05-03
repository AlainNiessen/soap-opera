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
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
    
        //récupération langue
        $lang = $request-> getLocale();
        //définition repository beurre
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);
        
        // récupération 3 Bestseller sur base de nombre de ventes       
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // récupération des articles      
        $tabBestseller = $repositoryArticle -> findArticlesBestseller(3);
        
        //récupération des informations sur les articles dans la langue
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticlesBest = $repositoryTraductionArticle -> findTraductionArticles($tabBestseller, $langue);

        // récupération 6 nouveautés sur base de la date de création     
        //définition repository article
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // récupération des articles      
        $tabNewArticles = $repositoryArticle -> findNewArticles(6);
        
        //récupération des informations sur les articles dans la langue
        $repositoryTraductionArticle = $entityManager -> getRepository(TraductionArticle::class);
        $resultTraductionArticlesNew = $repositoryTraductionArticle -> findTraductionArticles($tabNewArticles, $langue);


        return $this->render('home/index.html.twig', [
            'traductionArticlesBestseller' => $resultTraductionArticlesBest,
            'traductionArticlesNew' => $resultTraductionArticlesNew,
        ]);
    }
}
