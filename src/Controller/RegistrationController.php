<?php

namespace App\Controller;

use DateTime;
use App\Entity\Adresse;
use App\Entity\Utilisateur;
use Symfony\Component\Mime\Address;
use App\Form\InscriptionUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $entityManager, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        //création nouveau utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur -> setRoles(['ROLE_USER']);
        $utilisateur -> setDateInscription(new DateTime());
        $utilisateur -> setInscriptionValide(false);
        $utilisateur -> setInscriptionToken(null);

        //création formulaire 
        $formInscription = $this->createForm(InscriptionUtilisateurType::class, $utilisateur);
        $formInscription ->handleRequest($request);

        //si le formulaire a été submit et valid
        if($formInscription -> isSubmitted() && $formInscription -> isValid()):
            //récupération des données du formulaire
            $utilisateur = $formInscription -> getData();

            $homeAdresseCodePostal = $utilisateur -> getAdresseHome() -> getCodePostal();
            $homeAdressePays = $utilisateur -> getAdresseHome() -> getPays();
            $deliverAdresseCodePostal = $utilisateur -> getAdresseDeliver() -> getCodePostal();
            $deliverAdressePays = $utilisateur -> getAdresseHome() -> getPays();
            
            if(((strlen($homeAdresseCodePostal) == 4 && $homeAdressePays == "BE") || (strlen($homeAdresseCodePostal) == 5 && $homeAdressePays == "DE")) && ((strlen($deliverAdresseCodePostal) == 4 && $deliverAdressePays == "BE") || (strlen($deliverAdresseCodePostal) == 5 && $deliverAdressePays == "DE"))):
                $newsletterUtilisateur = $formInscription -> getData('newsletterCategorie');
                if(!empty($newsletterUtilisateur)):
                    foreach($newsletterUtilisateur as $newsletter):
                        $utilisateur -> addNewsletterCategory($newsletter);
                    endforeach;
                endif;
                // hasher the plain password
                $utilisateur->setPassword(
                    $encoder->hashPassword(
                        $utilisateur,
                        $formInscription->get('plainPassword')->getData()
                    )
                );

                //appel à la fonction privée generateToken pour générer le Token et l'attribuer à l'utilisateur créé dans le formulaire
                $utilisateur -> setInscriptionToken($this -> generateToken());  

                // vérification si il y en a des adresses dans la BD
                // appel de deux fonctions de vérification pour les deux adresses
                $this -> checkAdressesHome($utilisateur, $entityManager);
                $this -> checkAdressesDeliver($utilisateur, $entityManager);
                
                //préparation insertion dans la BD
                $entityManager -> persist($utilisateur);
                //insertion BD
                $entityManager -> flush();

                //sujet à traduire
                $messageSubject = $translator -> trans('Einschreibungsbestätigung');
                //validation par mail après enregistrement de l'utilisateur
                $email = (new TemplatedEmail())
                ->from('alain_niessen@hotmail.com') //de qui
                ->to(new Address($utilisateur -> getEmail())) //vers adresse mail du utilisateur
                ->subject($messageSubject) //sujet
                ->htmlTemplate('emails/signup.html.twig') //création template email signup
                ->context([
                    //passage des informations au template twig (token)
                    'token' => $utilisateur -> getInscriptionToken(),
                    'salutation' => $utilisateur -> getPrenom()               
                ]);
                // envoi du mail
                $mailer -> send($email);  

                //ajout d'un message de réussite
                $messageEnvoiMail = $translator -> trans('Gut gemacht! Du wirst in Kürze eine Email erhalten, in der wir dich bitten, deine Einschreibung zu bestätigen!');
                $this -> addFlash('success', $messageEnvoiMail); 
                    
                return $this->redirectToRoute('home');
            else: 
                //ajout d'un message de faute 
                $message = $translator -> trans('Die Länge der Postleitzahl für belgische Städte ist genau 4 und für deutsche Städte genau 5.');
                $this -> addFlash('error', $message);

                return $this->render('registration/inscriptionUtilisateur.html.twig', [
                    'formInscription' => $formInscription -> createView()
                ]);            
            endif;
        endif;       

       return $this->render('registration/inscriptionUtilisateur.html.twig', [
            'formInscription' => $formInscription -> createView()
        ]);
    }

    //fonction de génération TOKEN
    private function generateToken() {        
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * @Route("/registration/validation/{token}", name="validation_registration")
     */
    public function validation($token, UtilisateurRepository $repository, EntityManagerInterface $entityManager, TranslatorInterface $translator) :Response
    {
        
        //récupération de l'utilisateur avec le token
        $utilisateur = $repository -> findOneBy(["inscriptionToken" => $token]);

        //si il y en a un utilisateur correspondant avec le token
        if($utilisateur) {

            //remettre pour l'utilisateur le token à null et la confirmation de l'inscription à true dans la BD
            $utilisateur->setInscriptionToken(null);
            $utilisateur->setInscriptionValide(true);
            //préparation insertion changement utilisateur 
            $entityManager -> persist($utilisateur);
            //insertion danas la BD
            $entityManager -> flush();
                        
            //ajout d'un message de réussite 
            $messageInscription = $translator -> trans('Geschafft! Du bist nun eingeschrieben!');
            $this -> addFlash('success', $messageInscription); 
                
            return $this->redirectToRoute('home');
        } else {
            //ajout d'un message d'erreur pour la première partie de l'inscription
            $messageErreur = $translator -> trans('Ein Fehler ist aufgetreten');
            $this -> addFlash('error', $messageErreur);
            return $this->redirectToRoute('home');
        }
    }

    // fonction qui va contrôler si une adresse existe déjà dans la base de données
    // si oui => attribution directe à l'utilisateur
    // si non => création et attribution par aprés
    public function checkAdressesHome(Utilisateur $utilisateur, EntityManagerInterface $entityManager) {
        //définition repository adresse
        $repositoryAdresse = $entityManager -> getRepository(Adresse::class);
        // fonction de requête sur base de données récupérées       
        $adresses = $repositoryAdresse -> findAll();
        // tableau de réfèrence
        $tabAdresses = []; 
        
        //création adresse home
        $adresseHome = new Adresse();
        $adresseHome->setNumeroRue($utilisateur->getAdresseHome()->getNumeroRue());
        $adresseHome->setRue($utilisateur->getAdresseHome()->getRue());
        $adresseHome->setCodePostal($utilisateur->getAdresseHome()->getCodePostal());
        $adresseHome->setVille($utilisateur->getAdresseHome()->getVille());
        $adresseHome->setPays($utilisateur->getAdresseHome()->getPays());

        if(!empty($adresses)):
            // boucle sur les adresses stockées dans la base de données        
            foreach($adresses as $adresse):
                // vérification si l'adresse home existe déjà
                if($adresse->getNumeroRue() == $adresseHome->getNumeroRue() &&
                    $adresse->getRue() == $adresseHome->getRue() &&
                    $adresse->getCodePostal() == $adresseHome->getCodePostal() &&
                    $adresse->getVille() == $adresseHome->getVille() &&
                    $adresse->getPays() == $adresseHome->getPays()):  
                            
                    // si oui => attribution directe de l'adresse existante à l'utilisateur
                    $utilisateur -> setAdresseHome($adresse);
                else:
                    // si non => stockage de l'adresse dans le tableau de référence
                    $tabAdresses[] = $adresse;                                         
                endif;            
            endforeach;
            
            // si le nombre des adresse dans la base de données est égal au nombre des adresses stockées dans mon tableau
            // => adresseHome est nouveau
            if(count($adresses) == count($tabAdresses)):
                //préparation insertion dans la BD
                $entityManager -> persist($adresseHome);
                //insertion BD
                $entityManager -> flush();

                $utilisateur -> setAdresseHome($adresseHome);  
            endif;
        // si non => tableau adresse dans la base de données est vide et création d'une première adresse
        else:
            //préparation insertion dans la BD
            $entityManager -> persist($adresseHome);
            //insertion BD
            $entityManager -> flush();

            $utilisateur -> setAdresseDeliver($adresseHome);
        endif;
    }

    public function checkAdressesDeliver(Utilisateur $utilisateur, EntityManagerInterface $entityManager) {
        //définition repository adresse
        $repositoryAdresse = $entityManager -> getRepository(Adresse::class);
        // fonction de requête sur base de données récupérées       
        $adresses = $repositoryAdresse -> findAll();
        // tableau de réfèrence
        $tabAdresses = [];        

        //création adresse Deliver
        $adresseDeliver = new Adresse();
        $adresseDeliver->setNumeroRue($utilisateur->getAdresseDeliver()->getNumeroRue());
        $adresseDeliver->setRue($utilisateur->getAdresseDeliver()->getRue());
        $adresseDeliver->setCodePostal($utilisateur->getAdresseDeliver()->getCodePostal());
        $adresseDeliver->setVille($utilisateur->getAdresseDeliver()->getVille());
        $adresseDeliver->setPays($utilisateur->getAdresseDeliver()->getPays());

        if(!empty($adresses)):
            // boucle sur les adresses stockées dans la base de données        
            foreach($adresses as $adresse):
                // vérification si l'adresse deliver existe déjà
                if( $adresse->getNumeroRue() == $adresseDeliver->getNumeroRue() &&
                    $adresse->getRue() == $adresseDeliver->getRue() &&
                    $adresse->getCodePostal() == $adresseDeliver->getCodePostal() &&
                    $adresse->getVille() == $adresseDeliver->getVille() &&
                    $adresse->getPays() == $adresseDeliver->getPays()):  
                          
                    // si oui => attribution directe de l'adresse existante à l'utilisateur 
                    $utilisateur -> setAdresseDeliver($adresse);
                else:
                    // si non => stockage de l'adresse dans le tableau de référence
                    $tabAdresses[] = $adresse;                                         
                endif;            
            endforeach;
            
            // si le nombre des adresse dans la base de données est égal au nombre des adresses stockées dans mon tableau
            // => adresseDeliver est nouveau
            if(count($adresses) == count($tabAdresses)):
                //préparation insertion dans la BD
                $entityManager -> persist($adresseDeliver);
                //insertion BD
                $entityManager -> flush();

                $utilisateur -> setAdresseDeliver($adresseDeliver);  
            endif;
        // si non => tableau adresse dans la base de données est vide et création d'une première adresse
        else:
            //préparation insertion dans la BD
            $entityManager -> persist($adresseDeliver);
            //insertion BD
            $entityManager -> flush();

            $utilisateur -> setAdresseDeliver($adresseDeliver);
        endif;
    }
}
