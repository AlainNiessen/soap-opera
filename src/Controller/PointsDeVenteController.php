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
    //----------------------------------------------
    // ROUTE POINT DE VENTE
    //----------------------------------------------
    /**
     * @Route("/points-de-vente", name="points_de_vente")
     */
    public function pointsDeVente(Request $request, EntityManagerInterface $entityManager): Response
    {
        // récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);      
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);

        // récupération de tous les points de vente via PointDeVenteRepository
        $repositoryPointsDeVente = $entityManager -> getRepository(PointDeVente::class);    
        $pointsDeVente = $repositoryPointsDeVente -> findAll();  
        
        // préparation traductions points de vente
        $tabTraductionPointsDeVente = [];        
        // définition repository article
        $repositoryTraductionPointsDeVente = $entityManager -> getRepository(TraductionPointDeVente::class);

        foreach($pointsDeVente as $pointDeVente):           
            // récupération de la traduction des points de vente basée sur la langue dans la Session via TraductionPointDeVenteRepository
            $traductionPointDeVente = $repositoryTraductionPointsDeVente -> findTraductionPointDeVente($pointDeVente, $langue);
            $tabTraductionPointsDeVente[] = $traductionPointDeVente;

            //traitement adresse sur map via API mapbox
            //La fonction urlencode() est une fonction intégrée à PHP qui est utilisée pour encoder l'url (avec des caractéres spéciaux)
            $urlencode = urlencode($pointDeVente->getAdresse()->getNumeroRue().' '. $pointDeVente->getAdresse()->getRue().' '.$pointDeVente->getAdresse()->getCodePostal().' '.$pointDeVente->getAdresse()->getVille().' '.$pointDeVente->getAdresse()->getPays());
            //récupération latitude et longtitude sur base de l'adresse réelle du prestataire.
            $json = file_get_contents('https://api.mapbox.com/geocoding/v5/mapbox.places/'.$urlencode.'.json?access_token=pk.eyJ1IjoiYWxhaW4xOTc5IiwiYSI6ImNsMDU3ejZvejBvc3kzZHBkd2trODl5d24ifQ.ewy0L_R1PnylQtpX21Su3w');
            $obj = json_decode($json);
            $latitude = $obj->features[0]->geometry->coordinates[0];
            $longitude = $obj->features[0]->geometry->coordinates[1];
            $pointDeVente -> setLatitude($latitude);
            $pointDeVente -> setLongitude($longitude);

            //insertion dans la base de données
            $entityManager -> persist($pointDeVente);
            $entityManager -> flush();
        endforeach;
       
              
        return $this->render('points_de_vente/index.html.twig', [
            'traductionsPointsDeVente' => $tabTraductionPointsDeVente,
        ]);
    }
}
