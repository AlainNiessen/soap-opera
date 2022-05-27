<?php

namespace App\Security;

use App\Entity\Utilisateur; 
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class GoogleAuthenticator extends SocialAuthenticator
{
    
    private $clientRegistry;
    private $em;
    private $flash;
    private $translator;
    private $router;

 

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router, FlashBagInterface $flash, TranslatorInterface $translator)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->flash = $flash;
        $this->translator = $translator;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        // check la bonne route de redirection
        return $request->attributes->get('_route') === 'connect_google_check' && $request -> isMethod('GET');
    }

    public function getCredentials(Request $request)
    {
        // cette method est uniquement appéle si supports() return true
        return $this->fetchAccessToken($this->getGoogleClient());
    }

    
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $googleUser */
        // récupération des informations du client Google
        $googleUser = $this->getGoogleClient()
            ->fetchUserFromToken($credentials);
        
        // récupération de l'adresse Email du client Google
        $email = $googleUser->getEmail();
        
        // check si l'utilisateur existe dans la base de données via check by Email
        $utilisateur = $this->em->getRepository(Utilisateur::class)
            ->findOneBy(['email' => $email]);       
        
        return $utilisateur;
    }

    /**
     * @return \KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface
     */
    private function getGoogleClient()
    {
        return $this->clientRegistry            
            ->getClient('google');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {    
        // récupération de l'utilisateur connecté 
        $utilisateur = $token -> getUser();  
        if($utilisateur instanceof Utilisateur):
            // récupération du code Langue lié à l'utilisateur connecté
            $langueUtilisateur = $utilisateur -> getLangue() -> getCodeLangue();
            
            // définir cette langue dans la Session
            $request->getSession()->set('_locale', $langueUtilisateur);            
        endif;         
        
        // récupération de la page où on a cliqué sur se connecter
        $url = $request->getSession()->get('referer');
        // redirection vers cette page      
        return new RedirectResponse($url);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // message d'erreur
        $message = $this -> translator -> trans('Ein Konto mit dieser Email existiert leider nicht. Um sich mit dem Google-Konto anmelden zu können, bitten wir Sie, sich zuerst ein Konto mit der gleichen Email-adresse anzulegen!');        
        $this->flash->add('notice', $message);
        
        // redirect vers le formulaire d'inscription pour créer un compte
        return new RedirectResponse($this->router->generate('registration'));
    }

    /**
     * Called when authentication is needed, but it's not sent.
     * This redirects to the 'login'.
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse(
            '/connect/', // might be the site, where users choose their oauth provider
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    // ...
}