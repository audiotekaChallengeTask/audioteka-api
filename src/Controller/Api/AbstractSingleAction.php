<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Model\ModelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractSingleAction extends AbstractApiAction
{
    public function __invoke(Request $request): Response
    {
        $model = $this->loadModel($request);
        if (null === $model) {
            throw new NotFoundHttpException('Resource not found.');
        }

        return $this->representationResponse($model);
    }

    abstract protected function loadModel(Request $request): ?ModelInterface;
}
