<?php
declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Product;
use App\Model\ModelInterface;
use App\Representation\ProductRepresentation;
use App\Representation\RepresentationInterface;

class ProductRepresentationTransformer implements RepresentationTransformerInterface
{

    public function supports(ModelInterface $model): bool
    {
        return true === $model instanceof Product;
    }

    public function transform(ModelInterface $model): RepresentationInterface
    {
        /** @var Product $model */
        return new ProductRepresentation($model->getId(), $model->getName(), $model->getPrice());
    }
}
