<?php
declare(strict_types=1);

namespace App\Transformer;

use App\Exception\TransformationException;
use App\Model\ModelInterface;
use App\Representation\RepresentationInterface;

class RepresentationTransformer
{
    private RepresentationTransformerRepository $repository;

    public function __construct(RepresentationTransformerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function transform(ModelInterface $model): RepresentationInterface
    {
        foreach ($this->repository->getTransformers() as $transformer) {
            /** @var RepresentationTransformerInterface $transformer */
            if (true === $transformer->supports($model)) {
                return $transformer->transform($model);
            }
        }

        throw TransformationException::createForUnknownModel($model);
    }
}
