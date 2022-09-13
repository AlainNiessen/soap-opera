<?php

namespace App\Controller;

use App\Entity\Evaluation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EvaluationController extends AbstractController
{
    //----------------------------------------------
    // ROUTE MODIFICATION EVALUATION
    //----------------------------------------------
    /**
     * @Route("/modif-evaluation/{id}", name="modif_evaluation")
     */
    public function modifEvaluation(Evaluation $evaluation, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {  
        // s'il y a une évaluation passée via le formulaire de modification
        if(isset($_POST['note']) && !empty($_POST['note'])):

            // changement du nombre des étoiles
            $evaluation -> setNombreEtoiles($_POST['note']);
            
            // insertion dans la base de données
            $entityManager -> persist($evaluation);
            $entityManager -> flush();

            //ajout d'un message de réussite
            $message = $translator -> trans('Vielen Dank für deine neue Bewertung. Sie wird ebenfalls in die Gesamtbewertung einfliessen.');
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

    //----------------------------------------------
    // ROUTE SUPPRIMER EVALUATION
    //----------------------------------------------
    /**
     * @Route("/delete-evaluation/{id}", name="delete_evaluation")
     */
    public function deleteEvaluation(Evaluation $evaluation, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {  
        // récupération automatique de l'évaluation via son ID 

        // remove de la base de données
        $entityManager -> remove($evaluation);
        $entityManager -> flush();

        //ajout d'un message de réussite (avec paramétre nom de l'article)
        $message = $translator -> trans('Der Bewertung wurde erfolgreich gelöscht!');
        $this -> addFlash('success', $message);

        return $this->redirectToRoute('profile', [
            'id' => $this -> getUser() -> getId()
        ]);
    }
}
