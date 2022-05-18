<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\PasswordResetType;
use App\Form\EmailConfirmationType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        //si l'utilisateur est déjà connecté, il sera rediregé vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // login erreur
        $error = $authenticationUtils->getLastAuthenticationError();
        // lastUsername rentré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error, 
            //recupération du path où on va faire login
            'back_to_your_page' => $request->headers->get('referer')
        ]);
    }

    /**
     * @Route("/reset_password/email", name="reset_password", methods="GET|POST")
     */
    public function resetPasswordEmail(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        
        //création formulaire 
        $formPasswordResetEmail = $this->createForm(EmailConfirmationType::class);
        $formPasswordResetEmail -> handleRequest($request);      

        //si le formulaire a été submit et valid (uniquement le champs email)
        if ($formPasswordResetEmail->isSubmitted() && $formPasswordResetEmail->get('email')->isValid()):
            $email = $formPasswordResetEmail -> get('email') -> getData();

            //verification si l'utilisateur a rentré une adresse Email qui existe
            $repositoryUtilisateur = $entityManager -> getRepository(Utilisateur::class);
            $utilisateur = $repositoryUtilisateur -> findOneBy(['email' => $email]);

            //si l'adresse Email n'existe pas => pas d'utilisateur
            if(!$utilisateur):

                //message erreur et redirect vers formulaire
                $this -> addFlash('error', 'Bitte geben Sie eine existierende Emailadresse an oder legen Sie ein Konto an, falls Sie noch nicht registriert sind!');
                
                return $this->render('security/passwordReset.html.twig', [
                    'formPasswordReset' => $formPasswordResetEmail -> createView()
                ]);
            else: 
                //envoie d'un mail pour confirmer le changement de mot de passe
                $email = (new TemplatedEmail())
                ->from('alain_niessen@hotmail.com') //de qui
                ->to(new Address($utilisateur -> getEmail())) //vers adresse mail du utilisateur
                ->subject('Passwort ändern!') //sujet
                ->htmlTemplate('emails/password.html.twig') //création template email signup
                ->context([
                    //passage des informations au template twig (token)
                    'id' => $utilisateur -> getId(),
                    'salutation' => $utilisateur -> getPrenom()               
                ]);
                // envoi du mail
                $mailer -> send($email); 
                
                //ajout d'un message de réussite 
                $this -> addFlash('success', 'Du wirst in Kürze eine Email erhalten, in der du dein Passwort anpassen kannst!'); 
                    
                return $this->redirectToRoute('home');

            endif;
        endif;

        return $this->render('security/emailConfirmation.html.twig', [
            'formPasswordResetEmail' => $formPasswordResetEmail -> createView()
        ]);
    }

    /**
     * @Route("/reset_password/validation/{id}", name="validation_password_reset")
     */
    public function resetPasswordValidation($id, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder): Response
    {
        // Récupération utilisateur
        //définition repository utilisateur
        $repositoryUtilisateur = $entityManager -> getRepository(Utilisateur::class);
        // fonction de requête sur base de données récupérées       
        $utilisateur = $repositoryUtilisateur -> findOneBy(['id' => $id]);
        //création formulaire 
        $formPasswordReset = $this->createForm(PasswordResetType::class, $utilisateur);
        $formPasswordReset -> handleRequest($request);

        //si le formulaire a été submit et valid (uniquement le champs pleinPassword)
        if ($formPasswordReset->isSubmitted() && $formPasswordReset->get('plainPassword')->isValid()):
            
            // hasher the plain password
            $utilisateur->setPassword(
                $encoder->hashPassword(
                    $utilisateur,
                    $formPasswordReset->get('plainPassword')->getData()
                )
            );
            //préparation insertion dans la BD
            $entityManager -> persist($utilisateur);
            //insertion BD
            $entityManager -> flush();

            //ajout d'un message de réussite 
            $this -> addFlash('success', 'Gut gemacht! Dein Passwort wurde erfolgreich geändert!'); 
                
            return $this->redirectToRoute('home');
        endif;

        return $this->render('security/passwordReset.html.twig', [
            'formPasswordReset' => $formPasswordReset -> createView()
        ]);
    }

    /**
     * @Route("/login/no_acces", name="no_acces")
     */
    //cette route sera appelé dans le cas où on essaie d'accéder à l'interface administration sans avoir les droits (ROLE_ADMIN)
    public function noAccess(): Response
    {
        //ajout d'un message pas accés
        $this -> addFlash('error', 'Sie haben nicht die Berechtigung für diesen Bereich!'); 
        //et redirection vers la page d'accueil        
        return $this->redirectToRoute('login');       
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
