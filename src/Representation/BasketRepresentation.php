<?php
declare(strict_types=1);

namespace App\Representation;

class BasketRepresentation implements RepresentationInterface
{
    private \DateTime $createdAt;
    private int       $productCount;
    private float     $amount;

    public function __construct(\DateTime $createdAt, int $productCount, float $amount)
    {
        $this->createdAt    = $createdAt;
        $this->productCount = $productCount;
        $this->amount       = $amount;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getProductCount(): int
    {
        return $this->productCount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
