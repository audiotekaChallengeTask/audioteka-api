<?php
declare(strict_types=1);

namespace App\Provider;

use App\Entity\Basket;
use App\Entity\Product;
use App\Model\AbstractPaginatedCollectionModel;
use App\Model\ModelInterface;
use App\Model\PaginationRequest;
use App\Model\ProductPaginatedCollectionModel;
use App\Repository\ProductRepository;

class ProductDataProvider implements DataProviderInterface, PaginatedDataProviderInterface
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function single(int $id): ?ModelInterface
    {
        return $this->repository->find($id);
    }

    public function newInstance(): ModelInterface
    {
        return new Product();
    }

    public function paginate(PaginationRequest $request): AbstractPaginatedCollectionModel
    {
        $data  = $this->repository->findForPagination($request);
        $total = $this->repository->fetchTotal($request);

        return new ProductPaginatedCollectionModel($data, $request->getPage(), $request->getLimit(), $total);
    }

    public function findOneBy(array $parameters = []): ?ModelInterface
    {
        return $this->repository->findOneBy($parameters);
    }

    public function findMultipleBy(array $parameters = []): array
    {
        return $this->repository->findBy($parameters);
    }

    public function getBasketProducts(Basket $basket): array
    {
        return $this->repository->getBasketProducts($basket);
    }
}
