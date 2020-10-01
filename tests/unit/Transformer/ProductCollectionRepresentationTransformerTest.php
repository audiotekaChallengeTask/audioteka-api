<?php

namespace App\Tests\Unit\Transformer;

use App\Entity\Product;
use App\Model\ProductCollectionModel;
use App\Representation\ProductCollectionRepresentation;
use App\Representation\ProductRepresentation;
use App\Transformer\ProductCollectionRepresentationTransformer;
use App\Transformer\RepresentationTransformer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductCollectionRepresentationTransformerTest extends AbstractTransformerTestCase
{
    private MockObject $transformer;

    protected function setUp(): void
    {
        $this->transformer = $this->createMock(RepresentationTransformer::class);
        $this->instance    = new ProductCollectionRepresentationTransformer($this->transformer);
    }

    protected function getSupportedMock()
    {
        return $this->createMock(ProductCollectionModel::class);
    }

    public function test()
    {
        $model     = $this->getSupportedMock();
        $entry1    = $this->createMock(Product::class);
        $response1 = $this->createMock(ProductRepresentation::class);

        $model->expects($this->once())->method('getResources')->willReturn([$entry1]);
        $this->transformer->expects($this->once())->method('transform')->with($entry1)->willReturn($response1);

        /** @var ProductCollectionRepresentation $representation */
        $representation = $this->instance->transform($model);

        $this->assertSame(1, count($representation->getResources()));
        $this->assertTrue(in_array($response1, $representation->getResources(), true));
    }
}
