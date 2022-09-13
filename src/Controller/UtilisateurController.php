<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Article;
use App\Entity\Evaluation;
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
    //----------------------------------------------
    // ROUTE PROFILE UTILISATEUR
    //----------------------------------------------
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profile(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager): Response
    {   
        // récupération langue via LangueRepository
        $codeLangue = $utilisateur -> getLangue() -> getCodeLangue();
        $langue = $utilisateur -> getLangue();       
        
        // récupération TraductionArticleRepository
        $repositoryTradArticles = $entityManager -> getRepository(TraductionArticle::class);
        // récupération des favoris
        $favoris = $utilisateur -> getArticles();
        $tabFavoris = [];
        // boucle sur les favoris
        foreach($favoris as $favori):
            $favoriID = $favori -> getId();
            // récupération de la traduction des favoris via TraductionArticleRepository
            $trad = $repositoryTradArticles -> findTraductionArticle($favoriID, $langue);             
            
            // push traduction dans le tableau
            array_push($tabFavoris, $trad);
        endforeach;
        
        // récupération TraductionNewsletterCategorie
        $repositoryTradCategorie = $entityManager -> getRepository(TraductionNewsletterCategorie::class);
        // récupération des categories
        $categories = $utilisateur -> getNewsletterCategories();
        $tabNomsCategories = [];
        foreach($categories as $categorie):
            // récupération de la traduction des categories Newsletter via TraductionNewsletterCategorieRepository
            $trad = $repositoryTradCategorie -> findTraduction($categorie, $codeLangue);                
            //récupération du nom de la catégorie dans la langue de l'utilisateur
            $categorieNom = $trad -> getNom();
            // push nom traduit dans le tableau
            array_push($tabNomsCategories, $categorieNom);
        endforeach;

        // Récupération des articles achetés
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
            // récupération de la traduction des articles achetés via TraductionArticleRepository
            $trad = $repositoryTradArticles -> findTraductionArticle($achatID, $langue);             
            // push article acheté dans le tableau
            array_push($tabAchatsUniquesTrad, $trad);
        endforeach; 
        
        // récupération des commentaires validés par l'administrateur (publication = true) via CommentaireRepository
        $repositoryCommentaires = $entityManager -> getRepository(Commentaire::class);
        $resultCommentaires = $repositoryCommentaires -> findCommentairesUtilisateur($utilisateur);
        $tabCommentairesArticles = [];
        foreach($resultCommentaires as $commentaire):
            $articleCommentID = $commentaire -> getArticle() -> getId();
            // récupération de la traduction des articles commentés via TraductionArticleRepository
            $trad = $repositoryTradArticles -> findTraductionArticle($articleCommentID, $langue);             
            // push article commenté dans le tableau
            array_push($tabCommentairesArticles, $trad);
        endforeach;  
        // effacer les doublons des articles commentés       
        $tabCommentairesArticlesUniques = array_unique($tabCommentairesArticles, SORT_REGULAR);

        // récupération des evaluations via EvaluationRepository
        $repositoryEvaluations = $entityManager -> getRepository(Evaluation::class);
        $resultEvaluations = $repositoryEvaluations -> findEvaluationsUtilisateur($utilisateur);        
        $tabEvaluationsArticles = [];
        foreach($resultEvaluations as $evaluation):
            $articleEvaluationID = $evaluation -> getArticle() -> getId();
            // récupération de la traduction des articles évalués via TraductionArticleRepository
            $trad = $repositoryTradArticles -> findTraductionArticle($articleEvaluationID, $langue);             
            // push article évalué dans le tableau
            array_push($tabEvaluationsArticles, $trad);
        endforeach;  
        
        return $this->render('utilisateur/profile.html.twig', [
            'utilisateur' => $utilisateur,
            'favoris' => $tabFavoris,
            'articlesAchat' => $tabAchatsUniquesTrad,
            'newsletterCategories' => $tabNomsCategories,
            'commentaires' => $resultCommentaires,
            'articlesCommentaires' => $tabCommentairesArticlesUniques,
            'evaluations' => $resultEvaluations,
            'articlesEvaluations' => $tabEvaluationsArticles
        ]);
    }

    //----------------------------------------------
    // ROUTE MODIFICATION UTILISATEUR
    //----------------------------------------------
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

            // insertion dans la base de données
            $entityManager -> persist($utilisateur);
            $entityManager -> flush();

            // rechange de la langue dans la Session
            $request -> getSession() -> set('_locale', $utilisateur -> getLangue() -> getCodeLangue());
            
            // ajout d'un message de réussite (avec paramétre nom de l'article)
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

    //----------------------------------------------
    // ROUTE MODIFICATION ADRESSES DE UTILISATEUR
    //----------------------------------------------
    /**
     * @Route("/modif-adresse/{id}/{type}", name="modif_adresse")
     */
    public function modifAdresse(Utilisateur $utilisateur, $type, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        // check sur type pour titre dans le formulaire
        // récupération de la langue de l'utilisateur
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

            // contrôle supplémentaire sur la relation code postal - pays
            if((strlen($codePostal) == 4 && $pays == "BE") || (strlen($codePostal) == 5 && $pays == "DE")):
                //attribution des valeurs à la nouvelle adresse
                $adresse -> setNumeroRue($numeroRue);
                $adresse -> setRue($rue);
                $adresse -> setCodePostal($codePostal);
                $adresse -> setVille($ville);
                $adresse -> setPays($pays);

                // check dans la base de données
                $this -> checkAdresseBD($utilisateur, $adresse, $type, $entityManager);

                // insertion dans la base de données
                $entityManager -> persist($utilisateur);
                $entityManager -> flush();

                //ajout d'un message de réussite (avec paramétre nom de l'article)
                $message = $translator -> trans('Die Änderungen wurden erfolgreich registriert');
                $this -> addFlash('success', $message);

                return $this->redirectToRoute('profile', [
                    'id' => $utilisateur -> getId()
                ]);
            else:
                //ajout d'un message de faute 
                $message = $translator -> trans('Die Länge der Postleitzahl für belgische Städte ist genau 4 und für deutsche Städte genau 5.');
                $this -> addFlash('error', $message);

                return $this->render('utilisateur/form_modif_adresse.html.twig', [
                    'formAdresse' => $formAdresse -> createView(),
                    'titre' => $titre
                ]); 
            endif;           
            
        endif;

        return $this->render('utilisateur/form_modif_adresse.html.twig', [
            'formAdresse' => $formAdresse -> createView(), 
            'titre' => $titre
        ]);
    }

    //----------------------------------------------
    // FONCTION DE CONTRÔLE SI ADRESSE EXISTE DEJA DANS LA BASE DE DONNEES (DIFFERENCE ENTRE ADRESSE HOME ET DELIVER FAITE PAR UN TYPE)
    // SI OUI => ATTRIBUTION DIRECTE A UTILISATEUR
    // SI NON => CREATION ADRESSE DANS LA BASE DE DONNEES ET ATTRIBUTION PAR APRES A UTILISATEUR
    //----------------------------------------------
    public function checkAdresseBD(Utilisateur $utilisateur, Adresse $adresse, $type, EntityManagerInterface $entityManager) {
        
        // récupération de toutes les adresses via AdresseRepository
        $repositoryAdresse = $entityManager -> getRepository(Adresse::class);   
        $adresses = $repositoryAdresse -> findAll();

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

    //----------------------------------------------
    // ROUTE SUPPRIMER FAVORI
    //----------------------------------------------
    /**
     * @Route("/delete-favori/{utilisateurID}/{articleID}", name="delete_favori")
     */
    public function deleteFavori($utilisateurID, $articleID, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {  
        // récupération utilisateur + article via UtilisateurRepository + ArticleRepository
        $repositoryUtilisateur = $entityManager -> getRepository(Utilisateur::class);
        $repositoryArticle = $entityManager -> getRepository(Article::class);
        $utilisateur = $repositoryUtilisateur -> findOneBy(['id' => $utilisateurID]);
        $article = $repositoryArticle -> findOneBy(['id' => $articleID]);

        // supprimer le favori
        $utilisateur -> removeArticle($article);

        // insertion dan sla base de données
        $entityManager -> persist($utilisateur);
        $entityManager -> flush();

        //ajout d'un message de réussite (avec paramétre nom de l'article)
        $message = $translator -> trans('Der Favorit wurde erfolgreich gelöscht!');
        $this -> addFlash('success', $message);

        return $this->redirectToRoute('profile', [
            'id' => $utilisateurID
        ]);
    }

    //----------------------------------------------
    // ROUTE SUPPRIMER UTILISATEUR
    //----------------------------------------------
    /**
     * @Route("/delete-utilisateur/{id}", name="delete-utilisateur")
     */
    public function deleteUtilisateur(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    { 
        // remove de la base de données
        $entityManager -> remove($utilisateur);
        $entityManager -> flush();

        //ajout d'un message de réussite (avec paramétre nom de l'article)
        $message = $translator -> trans('Schade, dass du uns verlässt, aber dein Konto wurde erfolgreich gelöscht. Falls du in Zukunft nochmal unsere Dienste in Anspruch nehmen möchtest, musst du dich wieder einschreiben!');
        $this -> addFlash('success', $message);

        return $this->redirectToRoute('home');
    }
        
    
}