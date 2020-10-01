<?php
declare(strict_types=1);

namespace App\Entity;

use App\Model\ModelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Product implements ModelInterface
{
    private ?int       $id;
    private ?string    $name;
    private ?float     $price;
    private ?\DateTime $deletedAt;
    private Collection $baskets;

    public function __construct()
    {
        $this->baskets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    public function setDeletedAt(?\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt instanceof \DateTime;
    }

    public function addBasket(Basket $basket): Product
    {
        if (false === $this->baskets->contains($basket)) {
            $this->baskets->add($basket);
            $basket->addProduct($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): Product
    {
        if (true === $this->baskets->contains($basket)) {
            $this->baskets->removeElement($basket);
            $basket->removeProduct($this);
        }

        return $this;
    }

    public function getBaskets(): Collection
    {
        return $this->baskets;
    }
}
