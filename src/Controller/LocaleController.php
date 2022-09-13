<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocaleController extends AbstractController
{
    //----------------------------------------------
    // ROUTE CHANGEMENT DE LA LANGUE
    //----------------------------------------------
    /**
     * @Route("/locale/{locale}", name="locale")
     */
    public function changeLocale($locale, Request $request): Response
    {
        // on stocke la langue demandé dans la session
        $session = $request -> getSession();
        $session -> set('_locale', $locale);

        //on revient sur la page précedente
        return $this->redirect($request -> headers -> get('referer'));
        
    }
}
