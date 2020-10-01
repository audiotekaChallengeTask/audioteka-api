<?php
declare(strict_types=1);

namespace App\Provider;

use App\Entity\Basket;
use App\Model\ModelInterface;
use App\Repository\BasketRepository;

class BasketDataProvider implements DataProviderInterface
{
    private BasketRepository $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function single(int $id): ?ModelInterface
    {
        return $this->repository->find($id);
    }

    public function findOneBy(array $parameters = []): ?ModelInterface
    {
        return $this->repository->findOneBy($parameters);
    }

    public function newInstance(): ModelInterface
    {
        $userIdentifier = 'user_1';
        $basket         = new Basket();
        $basket->setUser($userIdentifier);

        return $basket;
    }

    public function findMultipleBy(array $parameters = []): array
    {
        return $this->repository->findBy($parameters);
    }

    public function getUserBasket(): ?Basket
    {
        $userIdentifier = 'user_1';

        // @todo extend for criteria that are not present for current app spec.
        return $this->repository->findOneBy(['user' => $userIdentifier]);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
