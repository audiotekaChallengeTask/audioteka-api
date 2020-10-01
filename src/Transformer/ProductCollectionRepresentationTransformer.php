<?php
declare(strict_types=1);

namespace App\Transformer;

use App\Model\ModelInterface;
use App\Model\ProductCollectionModel;
use App\Representation\ProductCollectionRepresentation;
use App\Representation\RepresentationInterface;

class ProductCollectionRepresentationTransformer implements RepresentationTransformerInterface
{
    private RepresentationTransformer $transformer;

    public function __construct(RepresentationTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function supports(ModelInterface $model): bool
    {
        return true === $model instanceof ProductCollectionModel;
    }

    public function transform(ModelInterface $model): RepresentationInterface
    {
        $data = [];
        /** @var $model ProductCollectionModel */
        foreach ($model->getResources() as $entry) {
            $data[] = $this->transformer->transform($entry);
        }

        return new ProductCollectionRepresentation($data);
    }
}
