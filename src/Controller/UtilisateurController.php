<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Article;
use App\Form\AdresseType;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use App\Form\AdresseChangeType;
use App\Entity\TraductionArticle;
use App\Form\InfoUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TraductionNewsletterCategorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profile(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager): Response
    {
        

        // récupération de la langue 
        $codeLangue = $utilisateur -> getLangue() -> getCodeLangue();
        $langue = $utilisateur -> getLangue();
       
        
        //récupération des informations sur les articles dans la langue
        $repositoryTradArticles = $entityManager -> getRepository(TraductionArticle::class);
        // récupération des favoris
        $favoris = $utilisateur -> getArticles();
        $tabFavoris = [];
        foreach($favoris as $favori):
            $favoriID = $favori -> getId();
            //appel à la fonction findTraductionArticle pour trouver la traduction de favoris
            $trad = $repositoryTradArticles -> findTraductionArticle($favoriID, $langue);             
            //récupération du nom de la catégorie dans la langue de l'utilisateur
            array_push($tabFavoris, $trad);
        endforeach;
        
        // récupération des catégories des Newsletter
        //connection au repository TraductionNewsletterCategorie
        $repositoryTradCategorie = $entityManager -> getRepository(TraductionNewsletterCategorie::class);
        $categories = $utilisateur -> getNewsletterCategories();
        $tabNomsCategories = [];
        foreach($categories as $categorie):
            //appel à la fonction findTraduction pour trouver la traduction de NewsletterCategorie 
            $trad = $repositoryTradCategorie -> findTraduction($categorie, $codeLangue);                
            //récupération du nom de la catégorie dans la langue de l'utilisateur
            $categorieNom = $trad -> getNom();
            array_push($tabNomsCategories, $categorieNom);
        endforeach;

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
        $tabAchatsUniquesTrad = [];
        foreach($tabAchatsUniques as $achat):
            $achatID = $achat -> getId();
            //appel à la fonction findTraductionArticle pour trouver la traduction de favoris
            $trad = $repositoryTradArticles -> findTraductionArticle($achatID, $langue);             
            //récupération du nom de la catégorie dans la langue de l'utilisateur
            array_push($tabAchatsUniquesTrad, $trad);
        endforeach; 
        
        // récupération des commentaires validés par l'administrateur (publication = true)
        // définition repository commentaires
        $repositoryCommentaires = $entityManager -> getRepository(Commentaire::class);
        // récupération des commentaires sur l'article 
        $resultCommentaires = $repositoryCommentaires -> findCommentairesUtilisateur($utilisateur);
        $tabCommentairesArticles = [];
        foreach($resultCommentaires as $commentaire):
            $articleCommentID = $commentaire -> getArticle() -> getId();
            //appel à la fonction findTraductionArticle pour trouver la traduction de favoris
            $trad = $repositoryTradArticles -> findTraductionArticle($articleCommentID, $langue);             
            //récupération du nom de la catégorie dans la langue de l'utilisateur
            array_push($tabCommentairesArticles, $trad);
        endforeach;         
           
        return $this->render('utilisateur/profile.html.twig', [
            'utilisateur' => $utilisateur,
            'favoris' => $tabFavoris,
            'articlesAchat' => $tabAchatsUniquesTrad,
            'newsletterCategories' => $tabNomsCategories,
            'commentaires' => $resultCommentaires,
            'articlesCommentaires' => $tabCommentairesArticles
        ]);
    }

    /**
     * @Route("/modif-utilisateur/{id}", name="modif")
     */
    public function modifUtilisateur(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {        
        // récupération du formulaire info utilisateur     
        $formUtilisateurInfo = $this->createForm(InfoUtilisateurType::class, $utilisateur);        
        $formUtilisateurInfo -> handleRequest($request);

        
        //si le formulaire est submit et valide
        if($formUtilisateurInfo -> isSubmitted() && $formUtilisateurInfo -> isValid()):           

            // préparation update
            $entityManager -> persist($utilisateur);
            // insertion BD du update
            $entityManager -> flush();

            // rechange de la langue dans la Session
            $request -> getSession() -> set('_locale', $utilisateur -> getLangue() -> getCodeLangue());
            
            //ajout d'un message de réussite (avec paramétre nom de l'article)
            $message = $translator -> trans('Die Änderungen wurden erfolgreich registriert');
            $this -> addFlash('success', $message);

            return $this->redirectToRoute('profile', [
                'id' => $utilisateur -> getId()
            ]);
           
        endif;
        

        return $this->render('utilisateur/form_modif_info.html.twig', [
            'formUtilisateurInfo' => $formUtilisateurInfo -> createView(), 
        ]);

    }

    /**
     * @Route("/modif-adresse/{id}/{type}", name="modif_adresse")
     */
    public function modifAdresse(Utilisateur $utilisateur, $type, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        // check sur type pour titre dans le formulaire
        // récupération de la langue 
        $langue = $utilisateur -> getLangue() -> getCodeLangue();
        if($type === "home"):
            if($langue === "de"):
                $titre = "Wohnadresse";
            elseif($langue === "fr"):
                $titre = "adresse résidentielle";
            elseif($langue === "en"):
                $titre = "residential address";
            endif;
        elseif($type === "deliver"):
            if($langue === "de"):
                $titre = "Liederadresse";
            elseif($langue === "fr"):
                $titre = "adresse de livraison";
            elseif($langue === "en"):
                $titre = "deliver address";
            endif;
        endif;
        // création nouvelle adresse
        $adresse = new Adresse();

        // récupération du formulaire Adresse     
        $formAdresse = $this->createForm(AdresseChangeType::class, $adresse);        
        $formAdresse -> handleRequest($request);

        //si le formulaire est submit et valide
        if($formAdresse -> isSubmitted() && $formAdresse -> isValid()):
            
            // récupération des valeurs du formulaire
            $numeroRue = $formAdresse -> get('numeroRue') -> getData();
            $rue = $formAdresse -> get('rue') -> getData();
            $codePostal= $formAdresse -> get('codePostal') -> getData();
            $ville = $formAdresse -> get('ville') -> getData();
            $pays = $formAdresse -> get('pays') -> getData();

            //attribution des valeurs à la nouvelle adresse
            $adresse -> setNumeroRue($numeroRue);
            $adresse -> setRue($rue);
            $adresse -> setCodePostal($codePostal);
            $adresse -> setVille($ville);
            $adresse -> setPays($pays);

            // check dans la base de données
            $this -> checkAdresseBD($utilisateur, $adresse, $type, $entityManager);

            // préparation update
            $entityManager -> persist($utilisateur);
            // insertion BD du update
            $entityManager -> flush();

            //ajout d'un message de réussite (avec paramétre nom de l'article)
            $message = $translator -> trans('Die Änderungen wurden erfolgreich registriert');
            $this -> addFlash('success', $message);

            return $this->redirectToRoute('profile', [
                'id' => $utilisateur -> getId()
            ]);
            
        endif;

        return $this->render('utilisateur/form_modif_adresse.html.twig', [
            'formAdresse' => $formAdresse -> createView(), 
            'titre' => $titre
        ]);
    }

    // fonction qui va contrôler si une adresse existe déjà dans la base de données
    // si oui => attribution directe à l'utilisateur
    // si non => création et attribution par aprés
    public function checkAdresseBD(Utilisateur $utilisateur, Adresse $adresse, $type, EntityManagerInterface $entityManager) {
        //définition repository adresse
        $repositoryAdresse = $entityManager -> getRepository(Adresse::class);
        // fonction de requête sur base de données récupérées       
        $adresses = $repositoryAdresse -> findAll();
        // tableau de réfèrence
        $tabAdresses = [];  
            
        // boucle sur les adresses stockées dans la base de données        
        foreach($adresses as $adresseBD):
            // vérification si l'adresse home existe déjà
            if( $adresseBD->getNumeroRue() == $adresse->getNumeroRue() &&
                $adresseBD->getRue() == $adresse->getRue() &&
                $adresseBD->getCodePostal() == $adresse->getCodePostal() &&
                $adresseBD->getVille() == $adresse->getVille() &&
                $adresseBD->getPays() == $adresse->getPays()):    
                // si oui => attribution directe de l'adresse existante à l'utilisateur 
                if($type === "home"):
                    $utilisateur -> setAdresseHome($adresseBD);
                elseif($type === "deliver"):
                    $utilisateur -> setAdresseDeliver($adresseBD);
                endif;
            else:
                // si non => stockage de l'adresse dans le tableau de référence
                $tabAdresses[] = $adresseBD;                                         
            endif;            
        endforeach;
        
        // si le nombre des adresse dans la base de données est égal au nombre des adresses stockées dans mon tableau
        // => adresseHome est nouveau
        if(count($adresses) == count($tabAdresses)):
            //préparation insertion dans la BD
            $entityManager -> persist($adresse);
            //insertion BD
            $entityManager -> flush();

            if($type === "home"):
                $utilisateur -> setAdresseHome($adresse);
            elseif($type === "deliver"):
                $utilisateur -> setAdresseDeliver($adresse);
            endif; 
        endif;
    }

    /**
     * @Route("/delete-favori/{utilisateurID}/{articleID}", name="delete_favori")
     */
    public function deleteFavori($utilisateurID, $articleID, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {  
        // récupération de l'utilisateur et l'article
        //définition repository utilisateur et article
        $repositoryUtilisateur = $entityManager -> getRepository(Utilisateur::class);
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        // récupération des éléments    
        $utilisateur = $repositoryUtilisateur -> findOneBy(['id' => $utilisateurID]);
        $article = $repositoryArticle -> findOneBy(['id' => $articleID]);

        // action delete
        $utilisateur -> removeArticle($article);
        //préparation insertion suppression service dans la BD
        $entityManager -> persist($utilisateur);
        //insertion
        $entityManager -> flush();

        //ajout d'un message de réussite (avec paramétre nom de l'article)
        $message = $translator -> trans('Der Favorit wurde erfolgreich gelöscht!');
        $this -> addFlash('success', $message);

        return $this->redirectToRoute('profile', [
            'id' => $utilisateurID
        ]);
    }
        
    
}