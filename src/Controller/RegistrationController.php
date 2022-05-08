<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionUtilisateurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request): Response
    {
        //création nouveau utilisateur
        $utilisateur = new Utilisateur();

        //création formulaire 
        $formInscription = $this->createForm(InscriptionUtilisateurType::class, $utilisateur);
        $formInscription ->handleRequest($request);

        //si le formulaire a été submit et valid
        if($formInscription -> isSubmitted() && $formInscription -> isValid()) {
            //récupération des données du formulaire
            $data = $formInscription -> getData();
            dd($data);
            // hasher the plain password
            // $utilisateur->setPassword(
            //     $encoder->hashPassword(
            //         $utilisateur,
            //         $formUtilisateur->get('plainPassword')->getData()
            //     )
            // );
            }

       return $this->render('registration/inscriptionUtilisateur.html.twig', [
            'formInscription' => $formInscription -> createView()
        ]);
    }
}
