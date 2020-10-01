<?php
declare(strict_types=1);

namespace App\Controller\Api\Product;

use App\Controller\Api\AbstractFormAction;
use App\Entity\Product;
use App\Form\Type\Product\EditType;
use App\Model\ModelInterface;
use App\Provider\ProductDataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditAction extends AbstractFormAction
{
    private ProductDataProvider $provider;

    public function __construct(ProductDataProvider $provider)
    {
        $this->provider = $provider;
    }

    protected function getResponseStatusCode(): int
    {
        return Response::HTTP_ACCEPTED;
    }

    protected function getMethod(): string
    {
        return Request::METHOD_PUT;
    }

    protected function getFormClassName(): string
    {
        return EditType::class;
    }

    protected function getModel(Request $request): ModelInterface
    {
        $model = $this->provider->single($request->attributes->getInt('id'));

        if (null === $model) {
            throw new NotFoundHttpException('Resource not found.');
        }

        return $model;
    }

    protected function getModelClassName(): string
    {
        return Product::class;
    }
}
