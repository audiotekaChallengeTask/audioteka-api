<?php
declare(strict_types=1);

namespace App\Transformer;

use App\Model\ModelInterface;
use App\Representation\RepresentationInterface;

interface RepresentationTransformerInterface
{
    public function supports(ModelInterface $model): bool;

    public function transform(ModelInterface $model): RepresentationInterface;
}
