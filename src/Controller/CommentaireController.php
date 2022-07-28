<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire/{id}", name="publier")
     */
    public function publier(Commentaire $commentaire, EntityManagerInterface $entityManager, TranslatorInterface $translator, Request $request): Response
    {
        // actualisation statut de publication du commentaire
        $commentaire -> setPublication(true);
        $entityManager -> persist($commentaire);
        $entityManager -> flush();

        // ajout d'un message de réussite
        $messagePublication = $translator -> trans('Der Kommentar wurde freigeschaltet');
        $this -> addFlash('success', $messagePublication);             
        
        // redirect vers la liste de commentaires avec message
        return $this->redirect($request -> headers -> get('referer'));
    }

    /**
     * @Route("/delete-commentaire/{id}", name="delete_commentaire")
     */
    public function deleteCommentaire(Commentaire $commentaire, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {  
        // récupération automatique du commentaire    

        //préparation insertion suppression service dans la BD
        $entityManager -> remove($commentaire);
        //insertion
        $entityManager -> flush();

        //ajout d'un message de réussite (avec paramétre nom de l'article)
        $message = $translator -> trans('Der Kommentar wurde erfolgreich gelöscht!');
        $this -> addFlash('success', $message);

        return $this->redirectToRoute('profile', [
            'id' => $this -> getUser() -> getId()
        ]);
    }
    /**
     * @Route("/modif-commentaire/{id}", name="modif_commentaire")
     */
    public function modifCommentaire(Commentaire $commentaire, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {  
        dd($commentaire);
        if(isset($_POST['commentaire']) && !empty($_POST['commentaire'])):

            // changement de la date et remis du boolean publication sur false pour une nouvelle vérification
            $commentaire -> setDateCommentaire(new \Datetime());
            $commentaire -> setPublication(false); // va être publié après vérification de l'administrateur
            $commentaire -> setContenu($_POST['commentaire']);

            //préparation insertion dans la BD
            $entityManager -> persist($commentaire);
            //insertion BD
            $entityManager -> flush();

            //ajout d'un message de réussite
            $message = $translator -> trans('Vielen Dank für deinen Kommentar. Nach Überprüfung wird dieser in Kürze freigeschaltet');
            $this -> addFlash('success', $message); 
        else: 
            //ajout d'un message de notice
            $message = $translator -> trans('Du hast keinen Kommentar abgegeben.');
            $this -> addFlash('notice', $message);
        endif;
        
        //redirect vers le détail de l'article
        return $this->redirectToRoute('profile', [
            'id' => $this -> getUser() -> getId()
        ]);
    }
}
