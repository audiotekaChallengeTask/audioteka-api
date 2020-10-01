<?php

namespace App\Tests\Unit\Security\Voter;

use App\Entity\Basket;
use App\Entity\Product;
use App\Representation\ProductRepresentation;
use App\Security\Voter\AddProductToBasketVoter;
use App\Security\Voter\HasBasketVoter;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AddProductToBasketVoterTest extends AbstractVoterTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->instance = new AddProductToBasketVoter(
            $this->accessDecisionManager,
            $this->basketProvider,
            $this->productRepository
        );
    }

    public function provideInvalidSupportData(): array
    {
        return [
            ['unsupported_attribute', 2],
            ['unsupported_attribute', null],
            ['some_other_attribute', null],
        ];
    }

    public function test_for_product_when_there_is_no_basket()
    {
        $product = $this->createMock(Product::class);
        $this->accessDecisionManager->expects($this->once())->method('decide')->with($this->token, [HasBasketVoter::PERMISSION])->willReturn(false);

        $this->assertSame(Voter::ACCESS_DENIED, $this->instance->vote($this->token, $product, [AddProductToBasketVoter::PERMISSION]));
    }

    public function test_for_representation_when_there_is_no_basket()
    {
        $productRepresentation = $this->createMock(ProductRepresentation::class);
        $this->accessDecisionManager->expects($this->once())->method('decide')->with($this->token, [HasBasketVoter::PERMISSION])->willReturn(false);

        $this->assertSame(Voter::ACCESS_DENIED, $this->instance->vote($this->token, $productRepresentation, [AddProductToBasketVoter::PERMISSION]));
    }

    public function test_for_product_when_there_is_basket_and_product_is_not_within_it_and_basket_accepts_new_products()
    {
        $product            = $this->createMock(Product::class);
        $basket             = $this->createMock(Basket::class);
        $productsCollection = $this->createMock(Collection::class);

        $productsCollection->expects($this->once())->method('count')->willReturn(2);
        $this->basketProvider->expects($this->once())->method('getUserBasket')->willReturn($basket);
        $this->accessDecisionManager->expects($this->once())->method('decide')->with($this->token, [HasBasketVoter::PERMISSION])->willReturn(true);
        $this->productRepository->expects($this->once())->method('basketHasProduct')->with($product, $basket)->willReturn(false);
        $basket->expects($this->once())->method('getProducts')->willReturn($productsCollection);

        $this->assertSame(Voter::ACCESS_GRANTED, $this->instance->vote($this->token, $product, [AddProductToBasketVoter::PERMISSION]));
    }

    public function test_for_representation_when_there_is_basket_and_product_is_not_within_it_and_basket_accepts_new_products()
    {
        $id = 1;

        $productRepresentation = $this->createMock(ProductRepresentation::class);
        $product               = $this->createMock(Product::class);
        $basket                = $this->createMock(Basket::class);
        $productsCollection    = $this->createMock(Collection::class);

        $productsCollection->expects($this->once())->method('count')->willReturn(2);
        $this->basketProvider->expects($this->once())->method('getUserBasket')->willReturn($basket);
        $productRepresentation->expects($this->once())->method('getId')->willReturn($id);
        $this->productRepository->expects($this->once())->method('find')->with($id)->willReturn($product);
        $this->productRepository->expects($this->once())->method('basketHasProduct')->with($product, $basket)->willReturn(false);
        $basket->expects($this->once())->method('getProducts')->willReturn($productsCollection);

        $this->accessDecisionManager->expects($this->once())->method('decide')->with($this->token, [HasBasketVoter::PERMISSION])->willReturn(true);

        $this->assertSame(Voter::ACCESS_GRANTED, $this->instance->vote($this->token, $productRepresentation, [AddProductToBasketVoter::PERMISSION]));
    }

    public function test_for_product_when_there_is_basket_and_product_is_within_it_and_basket_accepts_new_products()
    {
        $product            = $this->createMock(Product::class);
        $basket             = $this->createMock(Basket::class);

        $this->basketProvider->expects($this->once())->method('getUserBasket')->willReturn($basket);
        $this->accessDecisionManager->expects($this->once())->method('decide')->with($this->token, [HasBasketVoter::PERMISSION])->willReturn(true);
        $this->productRepository->expects($this->once())->method('basketHasProduct')->with($product, $basket)->willReturn(true);

        $this->assertSame(Voter::ACCESS_DENIED, $this->instance->vote($this->token, $product, [AddProductToBasketVoter::PERMISSION]));
    }

    public function test_for_representation_when_there_is_basket_and_product_is_within_it_and_basket_accepts_new_products()
    {
        $id = 1;

        $productRepresentation = $this->createMock(ProductRepresentation::class);
        $product               = $this->createMock(Product::class);
        $basket                = $this->createMock(Basket::class);

        $this->basketProvider->expects($this->once())->method('getUserBasket')->willReturn($basket);
        $productRepresentation->expects($this->once())->method('getId')->willReturn($id);
        $this->productRepository->expects($this->once())->method('find')->with($id)->willReturn($product);
        $this->productRepository->expects($this->once())->method('basketHasProduct')->with($product, $basket)->willReturn(true);

        $this->accessDecisionManager->expects($this->once())->method('decide')->with($this->token, [HasBasketVoter::PERMISSION])->willReturn(true);

        $this->assertSame(Voter::ACCESS_DENIED, $this->instance->vote($this->token, $productRepresentation, [AddProductToBasketVoter::PERMISSION]));
    }

    public function test_for_product_when_there_is_basket_and_product_is_not_within_it_but_basket_does_not_accept_new_products()
    {
        $product            = $this->createMock(Product::class);
        $basket             = $this->createMock(Basket::class);
        $productsCollection = $this->createMock(Collection::class);

        $productsCollection->expects($this->once())->method('count')->willReturn(3);
        $this->basketProvider->expects($this->once())->method('getUserBasket')->willReturn($basket);
        $this->accessDecisionManager->expects($this->once())->method('decide')->with($this->token, [HasBasketVoter::PERMISSION])->willReturn(true);
        $this->productRepository->expects($this->once())->method('basketHasProduct')->with($product, $basket)->willReturn(false);
        $basket->expects($this->once())->method('getProducts')->willReturn($productsCollection);

        $this->assertSame(Voter::ACCESS_DENIED, $this->instance->vote($this->token, $product, [AddProductToBasketVoter::PERMISSION]));
    }

    public function test_for_representation_when_there_is_basket_and_product_is_not_within_it_but_basket_does_not_accept_new_products()
    {
        $id = 1;

        $productRepresentation = $this->createMock(ProductRepresentation::class);
        $product               = $this->createMock(Product::class);
        $basket                = $this->createMock(Basket::class);
        $productsCollection    = $this->createMock(Collection::class);

        $productsCollection->expects($this->once())->method('count')->willReturn(3);
        $this->basketProvider->expects($this->once())->method('getUserBasket')->willReturn($basket);
        $productRepresentation->expects($this->once())->method('getId')->willReturn($id);
        $this->productRepository->expects($this->once())->method('find')->with($id)->willReturn($product);
        $this->productRepository->expects($this->once())->method('basketHasProduct')->with($product, $basket)->willReturn(false);
        $basket->expects($this->once())->method('getProducts')->willReturn($productsCollection);

        $this->accessDecisionManager->expects($this->once())->method('decide')->with($this->token, [HasBasketVoter::PERMISSION])->willReturn(true);

        $this->assertSame(Voter::ACCESS_DENIED, $this->instance->vote($this->token, $productRepresentation, [AddProductToBasketVoter::PERMISSION]));
    }
}
