<?php
declare(strict_types=1);

namespace App\Security\Voter;

use App\Provider\BasketDataProvider;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CreateNewBasketVoter extends Voter
{
    const PERMISSION = 'CREATE_NEW_BASKET';

    private BasketDataProvider $provider;

    public function __construct(BasketDataProvider $provider)
    {
        $this->provider = $provider;
    }

    protected function supports(string $attribute, $subject)
    {
        return $attribute === self::PERMISSION;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        return null === $this->provider->getUserBasket();
    }
}
