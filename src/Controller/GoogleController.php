<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    /**
     * Lien pour commencer le processus "connect"
     *
     * @Route("/connect/google", name="connect_google_start")
     * @param ClientRegistry $clientRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * 
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        // va rediriger vers Google
        return $clientRegistry
            ->getClient('google') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect();
    }

    /**
     * Rediriger vers la route de après GOOGLE
     * configuré dans le fichier config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/google/check", name="connect_google_check")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     * 
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        // test si il y a un utilisateur
        // le vrai traitement dans GoogleAuthenticator 
        if(!$this -> getUser()):
            return new JsonResponse(['status' => false, "message" => 'hello']);
        else:
            return $this -> redirectToRoute('home');
        endif;
    }
}