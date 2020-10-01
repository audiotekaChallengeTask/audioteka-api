<?php
declare(strict_types=1);

namespace App\Tests\Unit\Transformer;

use App\Model\ModelInterface;
use App\Tests\Unit\AbstractAppTestCase;
use App\Transformer\RepresentationTransformerInterface;

abstract class AbstractTransformerTestCase extends AbstractAppTestCase
{
    protected RepresentationTransformerInterface $instance;

    abstract protected function getSupportedMock();

    public function test_support_when_it_does_not()
    {
        $model = $this->createMock(ModelInterface::class);

        $this->assertFalse($this->instance->supports($model));
    }

    public function test_support_when_it_does()
    {
        $model = $this->getSupportedMock();

        $this->assertTrue($this->instance->supports($model));
    }
}
