<?php

namespace App\Controller;

use App\Entity\Facture;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivraisonController extends AbstractController
{
    /**
     * @Route("/livraison/{id}", name="livraison")
     */
    public function index(Facture $facture, Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        // récupération de l'utilisateur correspondant à la facture
        $utilisateur = $facture -> getUtilisateur();
        // Récupération de la langue de l'utilisateur
        $langueUtilisateur = $utilisateur -> getLangue() -> getCodeLangue();
        // préparation des textes correspondant à la langue
        if($langueUtilisateur === 'de'):
            $salutation = "Hallo ";
            $sujet = "Lieferbestätigung - Rechnung Nr";
            $confirmation = "Die Artikel bezüglich der Rechnung Nr. ".$facture -> getId()." wurden soeben an deine Lieferadresse verschickt";
            $salutationsDist = "Mit freundlichen Grüssen";
            $noms = "Sarah und Julia";
        elseif ($langueUtilisateur === "en"):
            $salutation = "Hello ";
            $sujet = "Delivery confirmation - invoice no.";
            $confirmation = "The articles related to invoice no. ".$facture -> getId()." have just been shipped to your shipping address";
            $salutationsDist = "Kind regards";
            $noms = "Sarah and Julia";
        elseif ($langueUtilisateur === "fr"):
            $salutation = "Salut ";
            $sujet = "Confirmation livraison - facture nr";
            $confirmation = "Les éléments liés à la facture nr. ".$facture -> getId()." viennent d'être expédiés à votre adresse de livraison";
            $salutationsDist = "Salutations distinguées";
            $noms = "Sarah et Julia";
        endif;
        
        // envoie mail de confirmation de livraison
        $email = (new TemplatedEmail())
        ->from('alain_niessen@hotmail.com') //de qui
        ->to(new Address($utilisateur -> getEmail())) //vers adresse mail du utilisateur
        ->subject($sujet.' '.$facture -> getId()) //sujet                        
        ->htmlTemplate('emails/confirmationLivraison.html.twig') //création template email confirmationLivraison
        ->context([
            //passage des informations au template twig 
            'nom' => $utilisateur -> getPrenom(),
            'confirmation' => $confirmation, 
            'salutation' => $salutation,         
            'salutationsDist' => $salutationsDist,         
            'noms' => $noms,         
        ]);

        // envoi du mail
        $mailer -> send($email);

        // actualisation statut de livraison pour la facture
        $facture -> setStatutLivraison(true);
        $entityManager -> persist($facture);
        $entityManager -> flush();

        // ajout d'un message de réussite
        $messageEnvoiMail = $translator -> trans('Die Lieferbestätigung ist an den Kunden gesendet!');
        $this -> addFlash('success', $messageEnvoiMail);             
        
        // redirect vers la liste de factures avec message
        return $this->redirect($request -> headers -> get('referer'));

    }
}
