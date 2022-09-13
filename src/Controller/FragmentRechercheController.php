<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\TraductionCategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FragmentRechercheController extends AbstractController
{
    //----------------------------------------------
    // ROUTE POUR AFFICHER LES CATEGORIES DANS LA SECTION RECHERCHE PAR CATEGORIE
    //----------------------------------------------
    /**
     * @Route("/fragment/recherche", name="recherche")
     */
    public function requestAllCategories(EntityManagerInterface $entityManager, Request $request): Response
    {
        // récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);     
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);
        
        // récupération de la traductions
        $repositoryTraductionCategorie = $entityManager -> getRepository(TraductionCategorie::class);
        $resultTraductionCategories = $repositoryTraductionCategorie -> findTraductionCategories($langue);
        
        return $this->render('fragment_recherche/_recherche.html.twig', [
            'traductionCategories' => $resultTraductionCategories
        ]);
    }
}
