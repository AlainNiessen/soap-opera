<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Categorie;
use App\Entity\TraductionCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FragmentRechercheController extends AbstractController
{
    /**
     * @Route("/fragment/recherche", name="recherche")
     */
    public function requestAllCategories(EntityManagerInterface $entityManager, Request $request): Response
    {
        //récupération langue
        $lang = $request-> getLocale();
        //définition repository beurre
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);
        
        //définition repository categorie
        $repositoryCategorie = $entityManager -> getRepository(Categorie::class);
        // fonction de requête => tous les categories dans la langue défini        
        $allCategories = $repositoryCategorie -> findAll();

        //récupération des informations sur les articles dans la langue
        $repositoryTraductionCategorie = $entityManager -> getRepository(TraductionCategorie::class);
        $resultTraductionCategories = $repositoryTraductionCategorie -> findTraductionCategories($allCategories, $langue);
        
        return $this->render('fragment_recherche/_recherche.html.twig', [
            'traductionCategories' => $resultTraductionCategories
        ]);
    }
}
