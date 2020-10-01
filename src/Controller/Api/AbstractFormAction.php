<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Model\ModelInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractFormAction extends AbstractApiAction
{
    protected function getResponseStatusCode(): int
    {
        return Response::HTTP_OK;
    }

    public function __invoke(Request $request): Response
    {
        if (null !== ($response = $this->preCreateForm($request))) {
            return $response;
        }

        $form = $this->formFactory->create($this->getFormClassName(), $this->getModel($request), ['method' => $this->getMethod()]);

        if (null !== ($response = $this->preHandleForm($request, $form))) {
            return $response;
        }

        $model = $this->formHandler->handle($form, $request);
        $this->postHandle($model);

        return $this->representationResponse($model, $this->getResponseStatusCode());
    }

    protected function preCreateForm(Request $request): ?Response
    {
        return null;
    }

    protected function preHandleForm(Request $request, FormInterface $form): ?Response
    {
        return null;
    }

    protected function postHandle(ModelInterface $model): void
    {
    }

    abstract protected function getModel(Request $request): ModelInterface;

    abstract protected function getMethod(): string;

    abstract protected function getFormClassName(): string;
}
