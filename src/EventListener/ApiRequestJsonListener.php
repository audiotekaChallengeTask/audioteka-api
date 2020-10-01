<?php
declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class ApiRequestJsonListener
{
    const EXPECTED_CONTENT_TYPE = 'application/json';

    public function onRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->headers->get('content-type') === self::EXPECTED_CONTENT_TYPE || $request->getContentType() === self::EXPECTED_CONTENT_TYPE) {
            $request->request->replace(json_decode($request->getContent(), true));
        }
    }
}
