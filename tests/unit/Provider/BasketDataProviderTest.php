<?php

namespace App\Tests\Unit\Provider;

use App\Entity\Basket;
use App\Provider\BasketDataProvider;
use App\Repository\BasketRepository;
use App\Tests\Unit\AbstractAppTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class BasketDataProviderTest extends AbstractAppTestCase
{
    protected BasketDataProvider $instance;

    /** @var MockObject|BasketRepository */
    protected $repository;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(BasketRepository::class);
        $this->instance   = new BasketDataProvider($this->repository);
    }

    public function test_single_for_existing_resource()
    {
        $id = 1;

        $model = $this->createMock(Basket::class);

        $this->repository->expects($this->once())->method('find')->with($id)->willReturn($model);
        $this->assertSame($model, $this->instance->single($id));
    }

    public function test_single_for_empty_resource()
    {
        $id = 1;

        $model = null;

        $this->repository->expects($this->once())->method('find')->with($id)->willReturn($model);
        $this->assertSame($model, $this->instance->single($id));
    }

    public function test_find_one_by()
    {
        $criteria = ['some_propert' => 'some_value'];

        $model = $this->createMock(Basket::class);

        $this->repository->expects($this->once())->method('findOneBy')->with($criteria)->willReturn($model);
        $this->assertSame($model, $this->instance->findOneBy($criteria));
    }

    public function test_new_instance()
    {
        $this->assertInstanceOf(Basket::class, $this->instance->newInstance());
    }

    public function test_find_multiple_by()
    {
        $criteria = ['some_propert' => 'some_value'];

        $model = [$this->createMock(Basket::class)];

        $this->repository->expects($this->once())->method('findBy')->with($criteria)->willReturn($model);
        $this->assertSame($model, $this->instance->findMultipleBy($criteria));
    }

    public function test_get_user_basket_when_exists()
    {
        $criteria = ['user' => 'user_1'];

        $model = $this->createMock(Basket::class);

        $this->repository->expects($this->once())->method('findOneBy')->with($criteria)->willReturn($model);
        $this->assertSame($model, $this->instance->getUserBasket());
    }

    public function test_get_user_basket_when_not_exists()
    {
        $criteria = ['user' => 'user_1'];

        $model = null;

        $this->repository->expects($this->once())->method('findOneBy')->with($criteria)->willReturn($model);
        $this->assertSame($model, $this->instance->getUserBasket());
    }
}
