<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FragmentNewArticlesController extends AbstractController
{
    /**
     * @Route("/fragment/new/articles", name="new_articles")
     */
    public function index(): Response
    {
        $tabNew = ["Article1", "Article2", "Article3", "Article4", "Article5", "Article6"];
        return $this->render('fragment_new_articles/_new.html.twig', [
            'tableauNewArticles' => $tabNew
        ]);
    }
}
