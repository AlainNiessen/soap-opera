<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FragmentRechercheController extends AbstractController
{
    /**
     * @Route("/fragment/recherche", name="recherche")
     */
    public function recherche(): Response
    {
        $tabTest = ["Seife", "Duschgel", "Deodorants", "Pflege", "Kerzen", "Zubehör"];

        return $this->render('Fragment_recherche/_recherche.html.twig', [
            'tableauTest' => $tabTest,
        ]);
    }
}
