<?php

namespace App\Controller;

use App\Entity\Commentaire;
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
}
