<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Utilisateur;
use App\Form\InfoUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profile(Utilisateur $utilisateur, Request $request): Response
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
            'articlesAchat' => $tabAchatsUniques,
        ]);
    }

    /**
     * @Route("/modif-utilisateur/{id}", name="modif", methods={"POST", "GET"})
     */
    public function modif(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
       
        // comme les adresses dans le formulaire de modification sont 'non-mappées'
        // récupération des adresses actuelles de l'utilisateur pour remplir les champs du formulaire
        // si on ne change rien, les adresses restent
        // si on fait un changement sur les adresses => les adresses parcourent les mêmes vérifications (pas de doublons) comme dans le formulaire d'inscription
        $adresseHomeActuel = $utilisateur -> getAdresseHome();
        $adresseDeliverActuel = $utilisateur -> getAdresseDeliver();        

        // récupération du formulaire info utilisateur     
        $formUtilisateurInfo = $this->createForm(InfoUtilisateurType::class, $utilisateur);
        // passage des adresses actuelles au formulaire
        $formUtilisateurInfo -> get('adresseHome') -> setData($adresseHomeActuel);
        $formUtilisateurInfo -> get('adresseDeliver') -> setData($adresseDeliverActuel);
        $formUtilisateurInfo -> handleRequest($request);

        
        //si le formulaire est submit et valide
        if($formUtilisateurInfo -> isSubmitted() && $formUtilisateurInfo -> isValid()):
            
            // récupération des nouvelles adresses non mappés
            $adresseHome = $formUtilisateurInfo->get("adresseHome")->getData();
            $adresseDeliver = $formUtilisateurInfo->get("adresseDeliver")->getData();
            $this -> checkAdressesHomeModif($utilisateur, $adresseHome, $entityManager);
            $this -> checkAdressesDeliverModif($utilisateur, $adresseDeliver, $entityManager);

            // préparation update
            $entityManager -> persist($utilisateur);
            // insertion BD du update
            $entityManager -> flush();
            
            //ajout d'un message de réussite (avec paramétre nom de l'article)
            $message = $translator -> trans('Die Änderungen wurden efolgreich registriert');
            $this -> addFlash('succes', $message);

            return $this->redirectToRoute('profile', [
                'id' => $utilisateur -> getId()
            ]);
           
        endif;
        

        return $this->render('utilisateur/form_modif_info.html.twig', [
            'formUtilisateurInfo' => $formUtilisateurInfo -> createView(), 
        ]);

    }

    // fonction qui va contrôler si une adresse existe déjà dans la base de données
    // si oui => attribution directe à l'utilisateur
    // si non => création et attribution par aprés
    public function checkAdressesHomeModif(Utilisateur $utilisateur, Adresse $adresse, EntityManagerInterface $entityManager) {
        //définition repository adresse
        $repositoryAdresse = $entityManager -> getRepository(Adresse::class);
        // fonction de requête sur base de données récupérées       
        $adresses = $repositoryAdresse -> findAll();
        // tableau de réfèrence
        $tabAdresses = [];  
        
        //création adresse home
        $adresseHome = new Adresse();
        $adresseHome->setNumeroRue($adresse->getNumeroRue());
        $adresseHome->setRue($adresse->getRue());
        $adresseHome->setCodePostal($adresse->getCodePostal());
        $adresseHome->setVille($adresse->getVille());
        $adresseHome->setPays($adresse->getPays());       

        // boucle sur les adresses stockées dans la base de données        
        foreach($adresses as $adresse):
            // vérification si l'adresse home existe déjà
            if( $adresse->getNumeroRue() == $adresseHome->getNumeroRue() &&
                $adresse->getRue() == $adresseHome->getRue() &&
                $adresse->getCodePostal() == $adresseHome->getCodePostal() &&
                $adresse->getVille() == $adresseHome->getVille() &&
                $adresse->getPays() == $adresseHome->getPays()):    
                // si oui => attribution directe de l'adresse existante à l'utilisateur 
                $utilisateur -> setAdresseHome($adresse);
            else:
                // si non => stockage de l'adresse dans le tableau de référence
                $tabAdresses[] = $adresse;                                         
            endif;            
        endforeach;
        
        // si le nombre des adresse dans la base de données est égal au nombre des adresses stockées dans mon tableau
        // => adresseHome est nouveau
        if(count($adresses) == count($tabAdresses)):
            //préparation insertion dans la BD
            $entityManager -> persist($adresseHome);
            //insertion BD
            $entityManager -> flush();

            $utilisateur -> setAdresseHome($adresseHome);  
        endif;
        
    }

    public function checkAdressesDeliverModif(Utilisateur $utilisateur, Adresse $adresse, EntityManagerInterface $entityManager) {
        //définition repository adresse
        $repositoryAdresse = $entityManager -> getRepository(Adresse::class);
        // fonction de requête sur base de données récupérées       
        $adresses = $repositoryAdresse -> findAll();
        // tableau de réfèrence
        $tabAdresses = [];        

       //création adresse home
       $adresseDeliver = new Adresse();
       $adresseDeliver->setNumeroRue($adresse->getNumeroRue());
       $adresseDeliver->setRue($adresse->getRue());
       $adresseDeliver->setCodePostal($adresse->getCodePostal());
       $adresseDeliver->setVille($adresse->getVille());
       $adresseDeliver->setPays($adresse->getPays());
        
       // boucle sur les adresses stockées dans la base de données        
       foreach($adresses as $adresse):
           // vérification si l'adresse home existe déjà
           if( $adresse->getNumeroRue() == $adresseDeliver->getNumeroRue() &&
                $adresse->getRue() == $adresseDeliver->getRue() &&
                $adresse->getCodePostal() == $adresseDeliver->getCodePostal() &&
                $adresse->getVille() == $adresseDeliver->getVille() &&
                $adresse->getPays() == $adresseDeliver->getPays()):         
                // si oui => attribution directe de l'adresse existante à l'utilisateur 
                $utilisateur -> setAdresseDeliver($adresse);
                
           else:
               // si non => stockage de l'adresse dans le tableau de référence
               $tabAdresses[] = $adresse;                                         
           endif;            
       endforeach;
       
       // si le nombre des adresse dans la base de données est égal au nombre des adresses stockées dans mon tableau
       // => adresseDeliver est nouveau
       if(count($adresses) == count($tabAdresses)):
           //préparation insertion dans la BD
           $entityManager -> persist($adresseDeliver);
           //insertion BD
           $entityManager -> flush();

           $utilisateur -> setAdresseDeliver($adresseDeliver);  
       endif;
    }
}
