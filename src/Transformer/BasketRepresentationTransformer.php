<?php
declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Basket;
use App\Model\ModelInterface;
use App\Repository\BasketRepository;
use App\Representation\BasketRepresentation;
use App\Representation\RepresentationInterface;

class BasketRepresentationTransformer implements RepresentationTransformerInterface
{
    private BasketRepository $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function supports(ModelInterface $model): bool
    {
        return true === $model instanceof Basket;
    }

    public function transform(ModelInterface $model): RepresentationInterface
    {
        /** @var $model Basket */
        $productsTotal = $model->getProducts()->count();
        $amountTotal   = $this->repository->selectSumOfPriceOfBasketProducts($model);

        return new BasketRepresentation($model->getCreatedAt(), $productsTotal, $amountTotal);
    }
}
