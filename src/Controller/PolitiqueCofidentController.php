<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolitiqueCofidentController extends AbstractController
{
    /**
     * @Route("/politique/cofident", name="politique_cofident")
     */
    public function index(): Response
    {
        return $this->render('politique_cofident/politique_cofident.html.twig');
    }
}
