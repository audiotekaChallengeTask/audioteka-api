<?php
declare(strict_types=1);

namespace App\Transformer;

use App\Model\ModelInterface;
use App\Model\ProductPaginatedCollectionModel;
use App\Representation\ProductCollectionRepresentation;
use App\Representation\RepresentationInterface;

class ProductPaginatedCollectionRepresentationTransformer implements RepresentationTransformerInterface
{
    private RepresentationTransformer $transformer;

    public function __construct(RepresentationTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function supports(ModelInterface $model): bool
    {
        return true === $model instanceof ProductPaginatedCollectionModel;
    }

    public function transform(ModelInterface $model): RepresentationInterface
    {
        /** @var $model ProductPaginatedCollectionModel */
        $data = [];
        foreach ($model->getResources() as $resource) {
            $data[] = $this->transformer->transform($resource);
        }

        return new ProductCollectionRepresentation($data);
    }
}
