<?php
declare(strict_types=1);

namespace App\Transformer;

class RepresentationTransformerRepository
{
    private array $transformers = [];

    public function registerTransformer(RepresentationTransformerInterface $transformer): void
    {
        $this->transformers[] = $transformer;
    }

    public function getTransformers(): array
    {
        return $this->transformers;
    }
}
