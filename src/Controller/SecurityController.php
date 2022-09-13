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
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    //----------------------------------------------
    // ROUTE LOGIN
    //----------------------------------------------
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        //si l'utilisateur est déjà connecté, il sera redirigé vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        //stockage de l'URL précedente dans la Session pour rediriger après login (UtilisateurAuthenticator + GoogleAuthenticator)
        $request->getSession()->set('referer', $request -> headers -> get('referer'));
        
        // login erreur
        $error = $authenticationUtils->getLastAuthenticationError();
        // lastUsername rentré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error
        ]);
    }

    //----------------------------------------------
    // ROUTE RESET MOT DE PASSE (OPTION SUR LE FORMULAIRE INSCRIPTION)
    //----------------------------------------------
    /**
     * @Route("/reset_password/email", name="reset_password", methods="GET|POST")
     */
    public function resetPasswordEmail(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        
        //création formulaire pour rentrer son e-mail
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
                $messageEmail = $translator -> trans('Bitte geben Sie eine existierende Emailadresse an oder legen Sie ein Konto an, falls Sie noch nicht registriert sind!');
                $this -> addFlash('error', $messageEmail);
                
                return $this->render('security/emailConfirmation.html.twig', [
                    'formPasswordResetEmail' => $formPasswordResetEmail -> createView()
                ]);

            else: 
                //envoie d'un mail pour confirmer le changement de mot de passe
                $messageSujetPass = $translator -> trans('Passwort ändern!');
                $email = (new TemplatedEmail())
                ->from('alain_niessen@hotmail.com') //de qui
                ->to(new Address($utilisateur -> getEmail())) //vers adresse mail du utilisateur
                ->subject($messageSujetPass) //sujet
                ->htmlTemplate('emails/password.html.twig') //création template email signup
                ->context([
                    //passage des informations au template twig (token)
                    'id' => $utilisateur -> getId(),
                    'salutation' => $utilisateur -> getPrenom()               
                ]);
                // envoi du mail
                $mailer -> send($email); 
                
                //ajout d'un message de réussite 
                $messageEmailPass = $translator -> trans('Du wirst in Kürze eine Email erhalten, in der du dein Passwort anpassen kannst!');
                $this -> addFlash('success', $messageEmailPass); 
                    
                // redirect vers la liste de commentaires avec message
                return $this->redirectToRoute('home');

            endif;
        endif;

        return $this->render('security/emailConfirmation.html.twig', [
            'formPasswordResetEmail' => $formPasswordResetEmail -> createView()
        ]);
    }

    //----------------------------------------------
    // ROUTE RESET MOT DE PASSE VALIDATION
    //----------------------------------------------
    /**
     * @Route("/reset_password/validation/{id}", name="validation_password_reset")
     */
    public function resetPasswordValidation(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder, TranslatorInterface $translator): Response
    {
        
        //création formulaire pour changer le mot de passe
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
            // insertion dans la base de données
            $entityManager -> persist($utilisateur);
            $entityManager -> flush();

            //ajout d'un message de réussite 
            $messageChangePass = $translator -> trans('Gut gemacht! Dein Passwort wurde erfolgreich geändert!');
            $this -> addFlash('success', $messageChangePass); 
                
            // si un utilisateur est connecté (reset mot de passe via son profile)
            if($this -> getUser()):
                return $this->redirectToRoute('profile', [
                    'id' => $utilisateur -> getID()
                ]);
            // sinon redirect vers home 
            else:
                return $this->redirectToRoute('home');
            endif;
        endif;

        return $this->render('security/passwordReset.html.twig', [
            'formPasswordReset' => $formPasswordReset -> createView()
        ]);
    }

    //----------------------------------------------
    // ROUTE ACCES REFUSE POUR INTERFACE ADMINISTRATION
    //----------------------------------------------
    /**
     * @Route("/login/no_acces", name="no_acces")
     */
    //cette route sera appelé dans le cas où on essaie d'accéder à l'interface administration sans avoir les droits (ROLE_SUPER_ADMIN ou ROLE_FINANCE_ADMIN)
    public function noAcces(TranslatorInterface $translator): Response
    {
        //ajout d'un message pas accés
        $messageNoAcces = $translator -> trans('Sie haben nicht die Berechtigung für diesen Bereich!');
        $this -> addFlash('error', $messageNoAcces); 
        //et redirection vers la page d'accueil        
        return $this->redirectToRoute('home');       
    }

    //----------------------------------------------
    // ROUTE LOGOUT
    //----------------------------------------------
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
