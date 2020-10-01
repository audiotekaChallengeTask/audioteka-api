<?php
declare(strict_types=1);

namespace App\Controller\Api\Product;

use App\Controller\Api\AbstractSingleAction;
use App\Entity\Product;
use App\Model\ModelInterface;
use App\Provider\ProductDataProvider;
use Symfony\Component\HttpFoundation\Request;

class SingleAction extends AbstractSingleAction
{
    private ProductDataProvider $provider;

    public function __construct(ProductDataProvider $provider)
    {
        $this->provider = $provider;
    }

    protected function getModelClassName(): string
    {
        return Product::class;
    }

    protected function loadModel(Request $request): ?ModelInterface
    {
        return $this->provider->single($request->attributes->getInt('id'));
    }
}
