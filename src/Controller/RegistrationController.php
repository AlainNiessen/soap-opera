<?php

namespace App\Controller;

use DateTime;
use App\Entity\Adresse;
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
    public function index(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $entityManager): Response
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
            // si non => boucle sur les adresses
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
            // si oui => création d'une première adresse
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
                        //si oui => attribution de l'adresse de la BD au nouveau utilisateur
                        $utilisateur -> setAdresseDeliver($adresse);
                else:
                    // stockage de l'adresse dans le tableau de référence
                    $tabRefDeliver[] = $adresse;                                       
                endif;
            endforeach;

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
        endif;



            

            
        

       return $this->render('registration/inscriptionUtilisateur.html.twig', [
            'formInscription' => $formInscription -> createView()
        ]);
    }

    //fonction de génération TOKEN
    private function generateToken() {        
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
