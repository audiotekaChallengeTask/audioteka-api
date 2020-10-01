<?php
declare(strict_types=1);

namespace App\Controller\Api\Product;

use App\Controller\Api\AbstractApiAction;
use App\Entity\Product;
use App\Manager\ProductDataManager;
use App\Provider\ProductDataProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteAction extends AbstractApiAction
{
    private ProductDataProvider $provider;
    private ProductDataManager  $manager;

    public function __construct(ProductDataProvider $provider, ProductDataManager $manager)
    {
        $this->provider = $provider;
        $this->manager  = $manager;
    }

    public function __invoke(int $id): Response
    {
        $model = $this->provider->single($id);
        if (null === $model) {
            throw new NotFoundHttpException('Resource not found.');
        }

        $this->manager->remove($model);

        return $this->emptyResponseWithStatus(Response::HTTP_ACCEPTED);
    }

    protected function getModelClassName(): string
    {
        return Product::class;
    }
}
