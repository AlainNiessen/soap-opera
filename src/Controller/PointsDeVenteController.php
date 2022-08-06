<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\PointDeVente;
use App\Entity\TraductionPointDeVente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PointsDeVenteController extends AbstractController
{
    /**
     * @Route("/points-de-vente", name="points_de_vente")
     */
    public function pointsDeVente(Request $request, EntityManagerInterface $entityManager): Response
    {
        //récupération langue
        $lang = $request-> getLocale();
        //définition repository beurre
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);

        //définition repository article
        $repositoryPointsDeVente = $entityManager -> getRepository(PointDeVente::class);
        // fonction de requête sur base de données récupérées       
        $pointsDeVente = $repositoryPointsDeVente -> findAll();  
        
        $tabTraductionPointsDeVente = [];
        //définition repository article
        $repositoryTraductionPointsDeVente = $entityManager -> getRepository(TraductionPointDeVente::class);
        foreach($pointsDeVente as $pointDeVente):
            $traductionPointDeVente = $repositoryTraductionPointsDeVente -> findTraductionPointDeVente($pointDeVente, $langue);
            $tabTraductionPointsDeVente[] = $traductionPointDeVente;
        endforeach;
              
        return $this->render('points_de_vente/index.html.twig', [
            'traductionsPointsDeVente' => $tabTraductionPointsDeVente,
        ]);
    }
}
