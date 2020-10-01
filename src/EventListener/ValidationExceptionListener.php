<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidationExceptionListener
{
    public function onValidationException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (false === $exception instanceof ValidationException) {
            return;
        }

        $response = new JsonResponse($exception->getErrors(), Response::HTTP_BAD_REQUEST);
        $event->setResponse($response);
    }
}
