<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class AuthenticationHandler
{

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        $token = $event->getAuthenticationToken();

        if ($token instanceof AnonymousToken) {
            return;
        }

        // session lifetime change on connect
        $this->request->getSession()->migrate(true, 86400);
    }
}