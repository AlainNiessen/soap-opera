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
    //----------------------------------------------
    // ROUTE ENVOYER NEWSLETTER VIA ACTION ENVOYER DANS INTERFACE ADMINISTRATION
    //----------------------------------------------
    /**
     * @Route("/newsletter/{id}", name="newsletter_send")
     */
    public function send(EntityManagerInterface $entityManager, Request $request, Newsletter $newsletter, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        // récupération de la catégorie du Newsletter 
        $categorie = $newsletter -> getNewsletterCategories();
        // récupération des utilisateurs qui ont choisi la catégorie
        $utilisateurs = $categorie -> getUtilisateurs();
        
        //boucle sur les utilisateurs
        foreach($utilisateurs as $utilisateur):

            // récupération de la langue de l'utilisateur + préparation des textes
            $langueUtilisateur = $utilisateur -> getLangue() -> getCodeLangue();
            if($langueUtilisateur === 'de'):
                $salutation = "Hallo ";
                $messageCancel = "Möchtest du den Newsletter nicht mehr erhalten? Du hast auf deinem Profil die Möglichkeit, die Newsletter anzupassen oder zu kündigen.";
                $salutationsDist = "Mit freundlichen Grüssen";
                $noms = "Sarah und Julia";
            elseif ($langueUtilisateur === "en"):
                $salutation = "Hello ";
                $messageCancel = "Do you no longer wish to receive the newsletter? You have the option to adjust or cancel the newsletter on your profile.";
                $salutationsDist = "Kind regards";
                $noms = "Sarah and Julia";
            elseif ($langueUtilisateur === "fr"):
                $salutation = "Salut ";
                $messageCancel = "Tu ne souhaites plus recevoir la newsletter ? Tu as la possibilité d'ajuster ou d'annuler la newsletter sur ton profil.";
                $salutationsDist = "Salutations distinguées";
                $noms = "Sarah et Julia";
            endif;

            // récupération langue via LangueRepository
            $repositoryLangue = $entityManager -> getRepository(Langue::class);                 
            $langue = $repositoryLangue -> findOneBy(['codeLangue' => $langueUtilisateur]); 

            //récupération des textes dans la langue de l'utilisateur via TraductionNewsletterRepository
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
                        'salutation' => $salutation,
                        'newsletterCategorieId' =>  $categorie -> getID(),
                        'utilisateurId' => $utilisateur -> getId(),
                        'messageCancel' => $messageCancel,
                        'salutationsDist' => $salutationsDist,         
                        'noms' => $noms        
                    ]);
                // sinon sans PDF
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
                        'salutation' => $salutation,
                        'newsletterCategorieId' =>  $categorie -> getID(),
                        'utilisateurId' => $utilisateur -> getId(),
                        'messageCancel' => $messageCancel,
                        'salutationsDist' => $salutationsDist,         
                        'noms' => $noms          
                    ]);
                endif;
                // envoi du mail
                $mailer -> send($email);
            endif;
        endforeach;

        // actualisation statut envoie du Newsletter dans la base de données + insertion dans la base de données
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
