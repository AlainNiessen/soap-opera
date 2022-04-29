<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FragmentRechercheController extends AbstractController
{
    /**
     * @Route("/fragment/recherche", name="recherche")
     */
    public function requestAllCategories(EntityManagerInterface $entityManager, TranslatorInterface $translator, Request $request): Response
    {
        // récupération de la langue 
        $lang = $request -> getLocale();
        
        //définition repository categorie
        $repositoryCategorie = $entityManager -> getRepository(Categorie::class);
        // fonction de requête => tous les categories dans la langue défini        
        $categories = $repositoryCategorie -> findAllCatgoriesLang($lang);
        
        return $this->render('fragment_recherche/_recherche.html.twig', [
            'categories' => $categories
        ]);
    }
}
