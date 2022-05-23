<?php

namespace App\Security;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class UtilisateurAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'login';

    private UrlGeneratorInterface $urlGenerator;
    private UtilisateurRepository $utilisateurRepository;

    public function __construct(UrlGeneratorInterface $urlGenerator, UtilisateurRepository $utilisateurRepository)
    {
        $this->urlGenerator = $urlGenerator;
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        //changer la langue dans la Session pour l'admin qui se connecte via la route /admin_s_op
        $user = $this->utilisateurRepository->findOneBy(['email' => $email]);
        if($user):
            $request -> getSession() -> set('_locale', $user -> getLangue() -> getCodeLangue());
        endif;

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email, function($userIdentifier) {
                // check si utilisateur existe OU si il a bien validé son inscription via Email
                $user = $this->utilisateurRepository->findOneBy(['email' => $userIdentifier]);
                if (!$user || $user->getInscriptionValide() == false) {
                    throw new UserNotFoundException();
                }          
                
                return $user;
            }),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new RememberMeBadge(),
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        

        // récupération de l'utilisateur connecté 
        $utilisateur = $token -> getUser();
        if($utilisateur instanceof Utilisateur):
            // récupération du code Langue lié à l'utilisateur connecté
            $langueUtilisateur = $utilisateur -> getLangue() -> getCodeLangue();
            // définir cette langue dans la Session
            $request->getSession()->set('_locale', $langueUtilisateur);            
        endif;

        // redirect vers la page où on vient se connecter (_target_path = name du input hidden dans le form login)
        // value de cet input = back_to_your_page (défini et passé vers le TWIG login dans SecurityController = $request->headers->get('referer'))
        return new RedirectResponse($request->get('_target_path'));
        
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
