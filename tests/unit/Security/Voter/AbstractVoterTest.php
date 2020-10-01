<?php
declare(strict_types=1);

namespace App\Tests\Unit\Security\Voter;

use App\Provider\BasketDataProvider;
use App\Provider\ProductDataProvider;
use App\Repository\BasketRepository;
use App\Repository\ProductRepository;
use App\Tests\Unit\AbstractAppTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

abstract class AbstractVoterTest extends AbstractAppTestCase
{
    protected Voter $instance;

    /** @var MockObject|AccessDecisionManagerInterface */
    protected $accessDecisionManager;

    /** @var MockObject|BasketDataProvider */
    protected $basketProvider;

    /** @var MockObject|BasketRepository */
    protected $basketRepository;

    /** @var MockObject|ProductDataProvider */
    protected $productProvider;

    /** @var MockObject|ProductRepository */
    protected $productRepository;

    /** @var MockObject|TokenInterface */
    protected $token;

    public function setUp(): void
    {
        $this->accessDecisionManager = $this->createMock(AccessDecisionManagerInterface::class);
        $this->basketProvider        = $this->createMock(BasketDataProvider::class);
        $this->productProvider       = $this->createMock(ProductDataProvider::class);
        $this->basketRepository      = $this->createMock(BasketRepository::class);
        $this->productRepository     = $this->createMock(ProductRepository::class);
        $this->token                 = $this->createMock(TokenInterface::class);
    }

    abstract public function provideInvalidSupportData(): array;

    /**
     * @param string $permission
     * @param null   $subject
     *
     * @dataProvider provideInvalidSupportData
     */
    public function test_supports_when_it_does_not(string $permission, $subject = null)
    {
        $this->assertEquals(VoterInterface::ACCESS_ABSTAIN, $this->instance->vote($this->token, $subject, [$permission]));
    }
}
