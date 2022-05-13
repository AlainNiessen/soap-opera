<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
     * @Route("/reset_password", name="reset_password")
     */
    public function resetPassword(): void
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
