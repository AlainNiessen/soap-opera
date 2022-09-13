<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Philosophie;
use App\Entity\PositionImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PhilosophieController extends AbstractController
{
    //----------------------------------------------
    // ROUTE PHILOSOPHIE
    //----------------------------------------------
    /**
     * @Route("/philosophie", name="philosophie")
     */
    public function philosophie(Request $request, EntityManagerInterface $entityManager): Response
    {
        // récupération langue via LangueRepository
        $lang = $request-> getLocale();
        $repositoryLangue = $entityManager -> getRepository(Langue::class);    
        $langue = $repositoryLangue -> findOneBy(['codeLangue' => $lang]);

        //récupération de la traduction de philosophie via PhilosophieRepository
        $repositoryPhilosophie = $entityManager -> getRepository(Philosophie::class);
        $philosophie = $repositoryPhilosophie -> findPhilosophie($langue);
        // récupération du text
        $philosophieText = $philosophie['philosophie'];

        //récupération des images pour le diaporama via PositionImageRepository
        $repositoryPositionImage = $entityManager -> getRepository(PositionImage::class);
        $position = $repositoryPositionImage -> findOneBy(['position' => 'Slider Philosophie']);
        $images = $position -> getImages();
               
        return $this->render('philosophie/index.html.twig', [
            'philosophie' => $philosophieText,
            'images' => $images
        ]);
    }
}
