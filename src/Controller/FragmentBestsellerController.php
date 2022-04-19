<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FragmentBestsellerController extends AbstractController
{
    /**
     * @Route("/fragment/bestseller", name="bestseller")
     */
    public function bestseller(): Response
    {
        $tabBesteller = ["Article1", "Article2", "Article3"];

        return $this->render('fragment_bestseller/_bestseller.html.twig', [
            'tableauBestseller' => $tabBesteller
        ]);
    }
}
