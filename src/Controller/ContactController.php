<?php

namespace App\Controller;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    { 
        // définition des valeurs dans les champs sur vide (première passage au formulaire)
        $nom      = "";
        $email    = "";
        $sujet    = "";
        $message  = "";      
        return $this->render('contact/contact.html.twig', [
            'nom' => $nom,
            'email' => $email,
            'sujet' => $sujet,
            'message' => $message
        ]);        
    }

    /**
     * @Route("/contact/email", name="contact_email", methods="GET|POST")
     */
    public function contactEmail(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        //récupération des données rentrées dans le fomulaire
        $nom      = $request -> request -> get('nom');
        $email    = $request -> request -> get('email');
        $sujet    = $request -> request -> get('sujet');
        $message  = $request -> request -> get('message');
        
        if(!empty($nom) && !empty($email) && !empty($sujet) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)):
            
            //envoie du email
            $emailSend = (new TemplatedEmail())
                ->from("alain_niessen@hotmail.com") //de qui
                ->to(new Address("alain_niessen@hotmail.com")) //vers adresse mail 
                ->replyTo($email)
                ->subject('Anfrage von '.$nom.' - '.$email.' / Betreff: '.$sujet) //sujet
                ->htmlTemplate('emails/contact.html.twig') //création template email contact 
                ->context([
                    'message' => $message, //passage du message au template           
                ])
            ;
            // envoi du mail
            $mailer -> send($emailSend); 
            
            //ajout d'un message de réussite
            $messageEnvoiMail = $translator -> trans('Deine Email ist erfolgreich versendet. Du wirst in Kürze Antwort erhalten!');
            $this -> addFlash('success', $messageEnvoiMail); 
                       
            //redirect vers la page où on a cliqué sur contact
            return $this->redirectToRoute('home');          
        else:
            
            // définition des messages d'erreur pour chaque champs + message d'erreur global

            if(empty($nom)):
                //ajout d'un message d'erreur
                $messageErrorNoName = $translator -> trans('Dieses Feld darf nicht leer bleiben');
                $this -> addFlash('errorNoName', $messageErrorNoName); 
            endif;
            if(empty($email)):
                //ajout d'un message d'erreur
                $messageErrorNoEmail = $translator -> trans('Dieses Feld darf nicht leer bleiben');
                $this -> addFlash('errorNoEmail', $messageErrorNoEmail); 
            endif;
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
                //ajout d'un message d'erreur
                $messageErrorInvalidEmail = $translator -> trans('Bitte gib eine korrekte Email an');
                $this -> addFlash('errorInvalidEmail', $messageErrorInvalidEmail); 
            endif;
            if(empty($sujet)):
                //ajout d'un message d'erreur
                $messageErrorNoSubject = $translator -> trans('Dieses Feld darf nicht leer bleiben');
                $this -> addFlash('errorNoSubject', $messageErrorNoSubject); 
            endif;
            if(empty($message)):
                //ajout d'un message d'erreur
                $messageErrorNoMessage = $translator -> trans('Dieses Feld darf nicht leer bleiben');
                $this -> addFlash('errorNoMessage', $messageErrorNoMessage); 
            endif;

            //ajout d'un message de réussite
            $messageError = $translator -> trans('Leider ist ein Fehler aufgetreten!');
            $this -> addFlash('error', $messageError); 
            
            // en cas d'erreur, on renvoit tous les valeurs pour les champs du formulaire
            return $this->render('contact/contact.html.twig', [
                'nom' => $nom,
                'email' => $email,
                'sujet' => $sujet,
                'message' => $message
            ]);
        endif;
    }
}
