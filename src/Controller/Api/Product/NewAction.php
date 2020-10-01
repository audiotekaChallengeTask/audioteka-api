<?php
declare(strict_types=1);

namespace App\Controller\Api\Product;

use App\Controller\Api\AbstractFormAction;
use App\Entity\Product;
use App\Form\Type\Product\NewType;
use App\Manager\ProductDataManager;
use App\Model\ModelInterface;
use App\Provider\ProductDataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewAction extends AbstractFormAction
{
    private ProductDataProvider $provider;
    private ProductDataManager  $manager;

    public function __construct(ProductDataProvider $provider, ProductDataManager $manager)
    {
        $this->provider = $provider;
        $this->manager  = $manager;
    }

    protected function getResponseStatusCode(): int
    {
        return Response::HTTP_CREATED;
    }

    protected function postHandle(ModelInterface $model): void
    {
        $this->manager->populate($model);
    }

    protected function getMethod(): string
    {
        return Request::METHOD_POST;
    }

    protected function getFormClassName(): string
    {
        return NewType::class;
    }

    protected function getModel(Request $request): ModelInterface
    {
        return $this->provider->newInstance();
    }

    protected function getModelClassName(): string
    {
        return Product::class;
    }
}
