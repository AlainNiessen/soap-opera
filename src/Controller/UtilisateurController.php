<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function index(Utilisateur $utilisateur): Response
    {
        // récupération des favoris
        $favoris = $utilisateur -> getArticles();

        // récupération des articles achetés
        $tabAchats = [];
        $factures = $utilisateur -> getFactures();
        foreach($factures as $facture):
            $commandes = $facture -> getDetailCommandeArticles();
            foreach($commandes as $commande):
                $article = $commande -> getArticle(); 
                array_push($tabAchats, $article);       
            endforeach;
        endforeach;

        // Éliminer les articles répétitifs
        $tabAchatsUniques = array_unique($tabAchats);       
        
        return $this->render('utilisateur/profile.html.twig', [
            'utilisateur' => $utilisateur,
            'favoris' => $favoris,
            'articlesAchat' => $tabAchatsUniques
        ]);
    }
}
