<?php
declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class KernelExceptionListener
{
    public function onException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();
        switch (get_class($throwable)) {
            case BadRequestHttpException::class:
                $event->setResponse($this->createResponse($throwable->getMessage(), Response::HTTP_BAD_REQUEST));
                break;
            case NotFoundHttpException::class:
                $event->setResponse($this->createResponse($throwable->getMessage(), Response::HTTP_NOT_FOUND));
                break;
            case UnprocessableEntityHttpException::class:
                $event->setResponse($this->createResponse($throwable->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY));
                break;

        }
    }

    private function createResponse(string $errorMessage, int $code): Response
    {
        return new JsonResponse(['error' => $errorMessage], $code);
    }
}
