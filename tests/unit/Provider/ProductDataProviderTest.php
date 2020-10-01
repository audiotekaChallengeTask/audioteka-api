<?php

namespace App\Tests\Unit\Provider;

use App\Entity\Basket;
use App\Entity\Product;
use App\Model\PaginationRequest;
use App\Model\ProductPaginatedCollectionModel;
use App\Provider\ProductDataProvider;
use App\Repository\ProductRepository;
use App\Tests\Unit\AbstractAppTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ProductDataProviderTest extends AbstractAppTestCase
{
    protected ProductDataProvider $instance;

    /** @var MockObject|ProductRepository */
    protected $repository;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(ProductRepository::class);
        $this->instance   = new ProductDataProvider($this->repository);
    }

    public function test_single_for_existing_resource()
    {
        $id = 1;

        $model = $this->createMock(Product::class);

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
        $this->assertInstanceOf(Product::class, $this->instance->newInstance());
    }

    public function test_find_multiple_by()
    {
        $criteria = ['some_propert' => 'some_value'];

        $model = [$this->createMock(Product::class)];

        $this->repository->expects($this->once())->method('findBy')->with($criteria)->willReturn($model);
        $this->assertSame($model, $this->instance->findMultipleBy($criteria));
    }

    public function test_paginate()
    {
        $total  = 1;
        $page   = 1;
        $limit  = 2;
        $model  = $this->createMock(Product::class);
        $models = [$model];

        $request = $this->createMock(PaginationRequest::class);

        $request->expects($this->once())->method('getPage')->willReturn($page);
        $request->expects($this->once())->method('getLimit')->willReturn($limit);
        $this->repository->expects($this->once())->method('findForPagination')->with($request)->willReturn($models);
        $this->repository->expects($this->once())->method('fetchTotal')->with($request)->willReturn($total);

        $response = $this->instance->paginate($request);

        $this->assertInstanceOf(ProductPaginatedCollectionModel::class, $response);
        $this->assertSame($total, $response->getTotal());
        $this->assertSame($page, $response->getPage());
        $this->assertSame($limit, $response->getLimit());
    }
}
