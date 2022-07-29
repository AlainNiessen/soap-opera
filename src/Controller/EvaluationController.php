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
    /**
     * @Route("/modif-evaluation/{id}", name="modif_evaluation")
     */
    public function modifEvaluation(Evaluation $evaluation, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {  
        
        if(isset($_POST['note']) && !empty($_POST['note'])):

        // changement de la date et remis du boolean publication sur false pour une nouvelle vérification
        $evaluation -> setNombreEtoiles($_POST['note']);
        
        //préparation insertion dans la BD
        $entityManager -> persist($evaluation);
        //insertion BD
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
        
        //redirect vers le détail de l'article
        return $this->redirectToRoute('profile', [
            'id' => $this -> getUser() -> getId()
        ]);
    }
    /**
     * @Route("/delete-evaluation/{id}", name="delete_evaluation")
     */
    public function deleteEvaluation(Evaluation $evaluation, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {  
        // récupération automatique de l'évaluation   

        //préparation insertion suppression service dans la BD
        $entityManager -> remove($evaluation);
        //insertion
        $entityManager -> flush();

        //ajout d'un message de réussite (avec paramétre nom de l'article)
        $message = $translator -> trans('Der Bewertung wurde erfolgreich gelöscht!');
        $this -> addFlash('success', $message);

        return $this->redirectToRoute('profile', [
            'id' => $this -> getUser() -> getId()
        ]);
    }
}
