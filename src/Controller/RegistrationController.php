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

            // récupération de toutes les adresses dans la BD => comparaison si les adresses fournies par le formulaire existent déjà 
            //définition repository adresse
            $repositoryAdresse = $entityManager -> getRepository(Adresse::class);
            // fonction de requête sur base de données récupérées       
            $adresses = $repositoryAdresse -> findAll();
            // tableau de réfèrence
            $tabRefHome = [];
            $tabRefDeliver = [];

            // vérification si il y en a des adresses dans la BD
            // si oui => boucle sur les adresses
            if(!empty($adresses)):
                foreach($adresses as $adresse):
                    // si l'adresse du formulaire existe déjà 
                    if( $adresse->getNumeroRue()    == $utilisateur->getAdresseHome()->getNumeroRue()   &&
                        $adresse->getRue()          == $utilisateur->getAdresseHome()->getRue()         &&
                        $adresse->getCodePostal()   == $utilisateur->getAdresseHome()->getCodePostal()  &&
                        $adresse->getVille()        == $utilisateur->getAdresseHome()->getVille()       &&  
                        $adresse->getPays()         == $utilisateur->getAdresseHome()->getPays()):         
                            // attribution de l'adresse de la BD au nouveau utilisateur
                            $utilisateur -> setAdresseHome($adresse);
                    else:
                        // stockage de l'adresse dans le tableau de référence
                        $tabRefHome[] = $adresse;                                         
                    endif;
                endforeach;
                // si l'adresse du formulaire n'existe pas encore
                if(count($adresses) == count($tabRefHome)):
                    // => création nouvelle adresse dans la BD et attribution par après à l'utilisateur
                    $adresseNew = new Adresse();
                    $adresseNew->setNumeroRue($utilisateur->getAdresseHome()->getNumeroRue());
                    $adresseNew->setRue($utilisateur->getAdresseHome()->getRue());
                    $adresseNew->setCodePostal($utilisateur->getAdresseHome()->getCodePostal());
                    $adresseNew->setVille($utilisateur->getAdresseHome()->getVille());
                    $adresseNew->setPays($utilisateur->getAdresseHome()->getPays()); 

                    //préparation insertion dans la BD
                    $entityManager -> persist($adresseNew);
                    //insertion BD
                    $entityManager -> flush();

                    $utilisateur -> setAdresseHome($adresseNew);  
                endif;
            // si non => création d'une première adresse
            else:
                $adresseNew = new Adresse();
                $adresseNew->setNumeroRue($utilisateur->getAdresseHome()->getNumeroRue());
                $adresseNew->setRue($utilisateur->getAdresseHome()->getRue());
                $adresseNew->setCodePostal($utilisateur->getAdresseHome()->getCodePostal());
                $adresseNew->setVille($utilisateur->getAdresseHome()->getVille());
                $adresseNew->setPays($utilisateur->getAdresseHome()->getPays()); 

                //préparation insertion dans la BD
                $entityManager -> persist($adresseNew);
                //insertion BD
                $entityManager -> flush();

                $utilisateur -> setAdresseHome($adresseNew);
            endif;

            // deuxiéme récupération des adresses pour parcourir le même chemin pour adresseDeliver   
            $adresses = $repositoryAdresse -> findAll();

            // directement la boucle car la base de données a au moins une adresse
            foreach($adresses as $adresse):
                //vérification si adresseDeliver existe déjà dans la BD
                if( $adresse->getNumeroRue()    == $utilisateur->getAdresseDeliver()->getNumeroRue()   &&
                    $adresse->getRue()          == $utilisateur->getAdresseDeliver()->getRue()         &&
                    $adresse->getCodePostal()   == $utilisateur->getAdresseDeliver()->getCodePostal()  &&
                    $adresse->getVille()        == $utilisateur->getAdresseDeliver()->getVille()       &&  
                    $adresse->getPays()         == $utilisateur->getAdresseDeliver()->getPays()):         
                        // attribution de l'adresse de la BD au nouveau utilisateur
                        $utilisateur -> setAdresseDeliver($adresse);
                else:
                    // stockage de l'adresse dans le tableau de référence
                    $tabRefDeliver[] = $adresse;                                       
                endif;
            endforeach;
            // si l'adresse du formulaire n'existe pas encore
            if(count($adresses) == count($tabRefDeliver)):
                //si non => création nouvelle adresse dans la BD et attribution par après à l'utilisateur
                $adresseNew = new Adresse();
                $adresseNew->setNumeroRue($utilisateur->getAdresseDeliver()->getNumeroRue());
                $adresseNew->setRue($utilisateur->getAdresseDeliver()->getRue());
                $adresseNew->setCodePostal($utilisateur->getAdresseDeliver()->getCodePostal());
                $adresseNew->setVille($utilisateur->getAdresseDeliver()->getVille());
                $adresseNew->setPays($utilisateur->getAdresseDeliver()->getPays()); 

                //préparation insertion dans la BD
                $entityManager -> persist($adresseNew);
                //insertion BD
                $entityManager -> flush();

                $utilisateur -> setAdresseDeliver($adresseNew);
            endif;

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
}
