<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Newsletter;
use Symfony\Component\Mime\Address;
use App\Entity\TraductionNewsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter/{id}", name="newsletter_send")
     */
    public function index(EntityManagerInterface $entityManager, Request $request, Newsletter $newsletter, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        // récupération de la catégorie du Newsletter
        $categorie = $newsletter -> getNewsletterCategories();
        $utilisateurs = $categorie -> getUtilisateurs();
        
        //boucle sur les utilisateurs
        foreach($utilisateurs as $utilisateur):

            // 1) Récupération de la langue de l'utilisateur
            $langueUtilisateur = $utilisateur -> getLangue() -> getCodeLangue();
            if($langueUtilisateur === 'de'):
                $salutation = "Hallo ";
            elseif ($langueUtilisateur === "en"):
                $salutation = "Hello ";
            elseif ($langueUtilisateur === "fr"):
                $salutation = "Salut ";
            endif;
            //définition repository langue
            $repositoryLangue = $entityManager -> getRepository(Langue::class);           
            // fonction de requête sur base de données récupérées       
            $langue = $repositoryLangue -> findOneBy(['codeLangue' => $langueUtilisateur]); 

            //récupération des textes dans la langue de l'utilisateur
            $repositoryTraductionNewsletter = $entityManager -> getRepository(TraductionNewsletter::class);
            $resultTraductionNewsletter = $repositoryTraductionNewsletter -> findTraductionNewsletter($newsletter, $langue);

            // création des Mails à chaque utilisateur inscrit pour la catégorie du Newsletter
            // verification si l'inscription de l'utilisateur est bien validée
            if($utilisateur -> getInscriptionValide()):
                // vérification si un PDF existe
                // si oui => attachement du fichier au mail
                if($resultTraductionNewsletter->getDocumentPDF()):
                    $email = (new TemplatedEmail())
                    ->from('alain_niessen@hotmail.com') //de qui
                    ->to(new Address($utilisateur -> getEmail())) //vers adresse mail du utilisateur
                    ->subject('Newsletter - '.$resultTraductionNewsletter -> getTitre()) //sujet               
                    ->attachFromPath('../public/uploads/newsletterPDF/'.$resultTraductionNewsletter->getDocumentPDF())            
                    ->htmlTemplate('emails/newsletter.html.twig') //création template email signup
                    ->context([
                        //passage des informations au template twig 
                        'message' => $resultTraductionNewsletter -> getDescription(), 
                        'nom' => $utilisateur -> getPrenom(),
                        'salutation' => $salutation           
                    ]);
                else:
                    $email = (new TemplatedEmail())
                    ->from('alain_niessen@hotmail.com') //de qui
                    ->to(new Address($utilisateur -> getEmail())) //vers adresse mail du utilisateur
                    ->subject('Newsletter - '.$resultTraductionNewsletter -> getTitre()) //sujet                        
                    ->htmlTemplate('emails/newsletter.html.twig') //création template email signup
                    ->context([
                        //passage des informations au template twig 
                        'message' => $resultTraductionNewsletter -> getDescription(), 
                        'nom' => $utilisateur -> getPrenom(),
                        'salutation' => $salutation         
                    ]);
                endif;
                // envoi du mail
                $mailer -> send($email);
            endif;
        endforeach;
        // actualisation statut envoie du Newsletter dans la base de données
        $newsletter -> setStatutEnvoie(true);
        $entityManager -> persist($newsletter);
        $entityManager -> flush();
        // ajout d'un message de réussite
        $messageEnvoiMail = $translator -> trans('Der Newsletter ist erfolgreich versendet');
        $this -> addFlash('success', $messageEnvoiMail); 
            
        // redirect vers la liste de newsletter avec message
        return $this->redirect($request -> headers -> get('referer'));
    }
}
