<?php

namespace App\Tests\Unit\Transformer;

use App\Exception\TransformationException;
use App\Model\ModelInterface;
use App\Representation\RepresentationInterface;
use App\Tests\Unit\AbstractAppTestCase;
use App\Transformer\RepresentationTransformer;
use App\Transformer\RepresentationTransformerInterface;
use App\Transformer\RepresentationTransformerRepository;
use PHPUnit\Framework\MockObject\MockObject;

class RepresentationTransformerTest extends AbstractAppTestCase
{
    private RepresentationTransformer $instance;
    private MockObject                $repository;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(RepresentationTransformerRepository::class);
        $this->instance   = new RepresentationTransformer($this->repository);
    }

    public function testTransformOnUnsupportedModel()
    {
        $this->expectException(TransformationException::class);
        $model = $this->createMock(ModelInterface::class);
        $this->instance->transform($model);
    }

    public function testTransform()
    {
        $representation = $this->createMock(RepresentationInterface::class);

        $model       = $this->createMock(ModelInterface::class);
        $transformer = $this->createMock(RepresentationTransformerInterface::class);

        $transformer->expects($this->once())->method('supports')->with($model)->willReturn(true);
        $transformer->expects($this->once())->method('transform')->with($model)->willReturn($representation);

        $this->repository->expects($this->once())->method('getTransformers')->willReturn([$transformer]);

        $this->instance->transform($model);
    }
}
