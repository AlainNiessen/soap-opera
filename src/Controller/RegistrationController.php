<?php

namespace App\Controller;

use DateTime;
use App\Entity\Utilisateur;
use App\Form\InscriptionUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager): Response
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
        if($formInscription -> isSubmitted() && $formInscription -> isValid()) {
            //récupération des données du formulaire
            $utilisateur = $formInscription -> getData();
            // hasher the plain password
            $utilisateur->setPassword(
                $encoder->hashPassword(
                    $utilisateur,
                    $formInscription->get('plainPassword')->getData()
                )
            );

            //appel à la fonction privée generateToken pour générer le Token et l'attribuer à l'utilisateur créé dans le formulaire
            $utilisateur -> setInscriptionToken($this -> generateToken());  
            }

            dd($utilisateur);

       return $this->render('registration/inscriptionUtilisateur.html.twig', [
            'formInscription' => $formInscription -> createView()
        ]);
    }

    //fonction de génération TOKEN
    private function generateToken() {        
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
