<?php

namespace App\Tests\Unit\Transformer;

use App\Entity\Product;
use App\Representation\ProductRepresentation;
use App\Transformer\ProductRepresentationTransformer;

class ProductRepresentationTransformerTest extends AbstractTransformerTestCase
{
    protected function setUp(): void
    {
        $this->instance = new ProductRepresentationTransformer();
    }

    protected function getSupportedMock()
    {
        return $this->createMock(Product::class);
    }

    public function testTransform()
    {
        $expectedId    = 1;
        $expectedPrice = 20.00;
        $expectedName  = 'name';

        $mock = $this->getSupportedMock();
        $mock->expects($this->once())->method('getId')->willReturn($expectedId);
        $mock->expects($this->once())->method('getPrice')->willReturn($expectedPrice);
        $mock->expects($this->once())->method('getName')->willReturn($expectedName);

        $representation = $this->instance->transform($mock);
        $this->assertInstanceOf(ProductRepresentation::class, $representation);

        /** @var ProductRepresentation $representation */
        $this->assertSame($expectedId, $representation->getId());
        $this->assertSame($expectedPrice, $representation->getPrice());
        $this->assertSame($expectedName, $representation->getName());
    }

}
