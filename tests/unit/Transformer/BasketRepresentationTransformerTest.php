<?php

namespace App\Tests\Unit\Transformer;

use App\Entity\Basket;
use App\Repository\BasketRepository;
use App\Representation\BasketRepresentation;
use App\Transformer\BasketRepresentationTransformer;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\MockObject\MockObject;

class BasketRepresentationTransformerTest extends AbstractTransformerTestCase
{
    private MockObject $repository;

    protected function getSupportedMock()
    {
        return $this->createMock(Basket::class);
    }

    protected function setUp(): void
    {
        $this->repository = $this->createMock(BasketRepository::class);
        $this->instance   = new BasketRepresentationTransformer($this->repository);
    }

    public function testTransform()
    {
        $expectedPrice        = 20.00;
        $expectedProductCount = 2;

        $mock                   = $this->getSupportedMock();
        $dateTimeMock           = $this->createMock(\DateTime::class);
        $productsCollectionMock = $this->createMock(Collection::class);

        $productsCollectionMock->expects($this->once())->method('count')->willReturn($expectedProductCount);
        $mock->expects($this->once())->method('getProducts')->willReturn($productsCollectionMock);

        $this->repository->expects($this->once())->method('selectSumOfPriceOfBasketProducts')->with($mock)->willReturn($expectedPrice);
        $mock->expects($this->once())->method('getCreatedAt')->willReturn($dateTimeMock);

        $representation = $this->instance->transform($mock);
        $this->assertInstanceOf(BasketRepresentation::class, $representation);

        /** @var BasketRepresentation $representation */
        $this->assertSame($expectedPrice, $representation->getAmount());
        $this->assertSame($expectedProductCount, $representation->getProductCount());
        $this->assertSame($dateTimeMock, $representation->getCreatedAt());
    }
}
