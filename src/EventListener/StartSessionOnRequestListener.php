<?php
declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class StartSessionOnRequestListener
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function onRequest(RequestEvent $event): void
    {
        if (false === $this->session->isStarted()) {
            $this->session->start();
        }
    }
}
