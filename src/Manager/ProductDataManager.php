<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Product;
use App\Model\ModelInterface;
use App\Repository\ProductRepository;

class ProductDataManager implements DataManagerInterface
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function remove(ModelInterface $model): void
    {
        $em = $this->repository->getEntityManager();
        $em->remove($model);
        $em->flush($model);
    }

    public function populate(ModelInterface $model): void
    {
        $em = $this->repository->getEntityManager();
        $em->persist($model);
        $em->flush($model);
    }
}
