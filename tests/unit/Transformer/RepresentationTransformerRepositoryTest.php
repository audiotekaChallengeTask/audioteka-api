<?php

namespace App\Tests\Unit\Transformer;

use App\Tests\Unit\AbstractAppTestCase;
use App\Transformer\RepresentationTransformerInterface;
use App\Transformer\RepresentationTransformerRepository;

class RepresentationTransformerRepositoryTest extends AbstractAppTestCase
{
    private RepresentationTransformerRepository $instance;

    public function testRegisterTransformer()
    {
        $transformer1 = $this->createMock(RepresentationTransformerInterface::class);
        $transformer2 = $this->createMock(RepresentationTransformerInterface::class);

        $this->instance->registerTransformer($transformer1);
        $this->instance->registerTransformer($transformer2);

        $this->assertTrue(in_array($transformer1, $this->instance->getTransformers(), true));
        $this->assertTrue(in_array($transformer2, $this->instance->getTransformers(), true));
    }

    protected function setUp(): void
    {
        $this->instance = new RepresentationTransformerRepository();
    }

}
