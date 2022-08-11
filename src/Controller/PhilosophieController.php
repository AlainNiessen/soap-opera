<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Philosophie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PhilosophieController extends AbstractController
{
    /**
     * @Route("/philosophie", name="philosophie")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        //récupération langue
        $lang = $request-> getLocale();
        //définition repository beurre
        $repositoryLangue = $entityManager -> getRepository(Langue::class);
        // fonction de requête sur base de données récupérées       
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);

        //récupération des informations sur les articles dans la langue
        $repositoryPhilosophie = $entityManager -> getRepository(Philosophie::class);
        $philosophie = $repositoryPhilosophie -> findPhilosophie($langue);
        $philosophieText = $philosophie['philosophie'];

        
        return $this->render('philosophie/index.html.twig', [
            'philosophie' => $philosophieText,
        ]);
    }
}
