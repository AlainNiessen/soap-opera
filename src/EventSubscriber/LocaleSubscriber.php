<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

//----------------------------------------------
// Ce "SUBSCRIBER" est destiné à contrôler à chaque requête
// la langue dans la Session. Si il y en a une langue stockée dans la Session, 
// elle sera appliqué, sinon c'est la langue par défault qui sera appliqué (de)
//----------------------------------------------
class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = 'de')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        // essayez de voir si la locale a été définie en tant que paramètre de routage _locale
        if ($locale = $request->query->get('_locale')) {
            $request->setLocale($locale);
        } else {
            // si aucune locale explicite n'a été définie sur cette requête, utilisez-en une de la session
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}