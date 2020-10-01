<?php

namespace App\Tests\Unit\Security\Voter;

use App\Entity\Basket;
use App\Security\Voter\CreateNewBasketVoter;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CreateNewBasketVoterTest extends AbstractVoterTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->instance = new CreateNewBasketVoter($this->basketProvider);
    }

    public function provideInvalidSupportData(): array
    {
        return [
            ['unsupported_attribute', 2],
            ['unsupported_attribute', null],
            ['some_other_attribute', null],
        ];
    }

    public function test_when_there_is_basket()
    {
        $basket = $this->createMock(Basket::class);
        $this->basketProvider->expects($this->once())->method('getUserBasket')->willReturn($basket);

        $this->assertSame(Voter::ACCESS_DENIED, $this->instance->vote($this->token, null, [CreateNewBasketVoter::PERMISSION]));
    }

    public function test_when_there_is_no_basket()
    {
        $this->basketProvider->expects($this->once())->method('getUserBasket')->willReturn(null);

        $this->assertSame(Voter::ACCESS_GRANTED, $this->instance->vote($this->token, null, [CreateNewBasketVoter::PERMISSION]));
    }
}
