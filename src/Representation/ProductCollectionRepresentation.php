<?php
declare(strict_types=1);

namespace App\Representation;

class ProductCollectionRepresentation implements RepresentationInterface
{
    private array $resources;

    public function __construct(array $resources)
    {
        $this->resources = $resources;
    }

    public function getResources(): array
    {
        return $this->resources;
    }
}
