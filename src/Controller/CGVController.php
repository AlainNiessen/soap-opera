<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CGVController extends AbstractController
{
    //----------------------------------------------
    // ROUTE CONDITIONS GENERALES DE VENTE (CGV)
    //----------------------------------------------
    /**
     * @Route("/cgv", name="cgv")
     */
    public function cgv(): Response
    {
        return $this->render('cgv/cgv.html.twig');
    }
}
