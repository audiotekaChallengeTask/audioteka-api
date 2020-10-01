<?php
declare(strict_types=1);

namespace App\Entity;

use App\Model\ModelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Basket implements ModelInterface
{
    private ?int            $id;
    private ?string         $user;
    private \DateTime       $createdAt;
    private Collection      $products;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->products  = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function addProduct(Product $product): Basket
    {
        if (false === $this->products->contains($product)) {
            $this->products->add($product);
            $product->addBasket($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): Basket
    {
        if (true === $this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeBasket($this);
        }

        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): void
    {
        $this->user = $user;
    }
}
