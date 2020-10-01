<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Basket;
use App\Entity\Product;
use App\Model\ModelInterface;
use App\Repository\BasketRepository;

class BasketDataManager implements DataManagerInterface
{
    private BasketRepository $repository;

    public function __construct(BasketRepository $repository)
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

    public function addProductToBasket(Product $product, Basket $basket): void
    {
        $basket->addProduct($product);
    }

    public function removeProductFromBasket(Product $product, Basket $basket): void
    {
        $basket->removeProduct($product);
    }
}
