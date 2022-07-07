<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaiementController extends AbstractController
{
    /**
     * @Route("/paiement/{total}", name="paiement", methods="post|get")
     */
    //injection de la clé secret de STRIPE défini dans services.yaml et .env
    public function paiement($total, $stripeSK, TranslatorInterface $translator): Response
    {
        // remplacement des "," par des "." (pour le float)
        $total = str_replace(',', '.', $total);        
        // changement du montant en float et total en centimes
        $total = floatval($total) * 100;
        // changement du float vers int
        $total = intval($total);    
        
        // définition de la clé de l'API
        // => clé secret passé par la platform Stripe
        Stripe::setApiKey($stripeSK);

        // nom pour la commande
        $nom = $translator -> trans('Deine Bestellung');

        //transfer des données de la transaction à Stripe
        $session = Session::create([
            'line_items' => [[
              'price_data' => [
                'currency' => 'eur', // Dans quelle devise le paiement doit-il être effectué ?
                'product_data' => [
                  'name' => $nom, // Nom pour les données du produit => dans mon cas => juste "Ta commande"
                ],
                'unit_amount' => $total, // Montant total transféré par l'URL, transformé d'abord en float * 100, aprés en integer (exemple: "20,50" => 2050)
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this -> generateUrl('succes', [], UrlGeneratorInterface::ABSOLUTE_URL), // redirection de Stripe en cas de succés (URL complét (ABSOLUTE) car redirection viens de Stripe)
            'cancel_url' => $this -> generateUrl('cancel', [], UrlGeneratorInterface::ABSOLUTE_URL), // redirection de Stripe en cas de échec (URL complét (ABSOLUTE) car redirection viens de Stripe)
          ]);
        
          // redirect vers l'interface de Stripe avec code 303 pour redirect
          return $this -> redirect($session -> url, 303);
    }

    /**
     * @Route("/succes", name="succes")
     */
    public function succes(): Response
    {
        
        return $this -> render('paiement/succes.html.twig');
    }

    /**
     * @Route("/cancel", name="cancel")
     */
    public function cancel(): Response
    {        

        return $this -> render('paiement/cancel.html.twig');
    }
}
