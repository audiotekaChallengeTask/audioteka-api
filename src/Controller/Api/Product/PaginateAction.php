<?php
declare(strict_types=1);

namespace App\Controller\Api\Product;

use App\Controller\Api\AbstractPaginateAction;
use App\Entity\Product;
use App\Model\AbstractPaginatedCollectionModel;
use App\Model\PaginationRequest;
use App\Provider\PaginatedDataProviderInterface;
use App\Provider\ProductDataProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaginateAction extends AbstractPaginateAction
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

    protected function getData(PaginationRequest $paginationRequest, Request $request): AbstractPaginatedCollectionModel
    {
        return $this->provider->paginate($paginationRequest);
    }
}
