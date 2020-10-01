<?php
declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Product;
use App\Provider\BasketDataProvider;
use App\Repository\ProductRepository;
use App\Representation\ProductRepresentation;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AddProductToBasketVoter extends Voter
{
    const PERMISSION = 'ADD_PRODUCT_TO_BASKET';

    private AccessDecisionManagerInterface $accessDecision;
    private BasketDataProvider             $provider;
    private ProductRepository              $repository;

    public function __construct(AccessDecisionManagerInterface $accessDecision, BasketDataProvider $provider, ProductRepository $repository)
    {
        $this->accessDecision = $accessDecision;
        $this->provider       = $provider;
        $this->repository     = $repository;
    }

    protected function supports(string $attribute, $subject)
    {
        return $attribute === self::PERMISSION && ($subject instanceof Product || $subject instanceof ProductRepresentation);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        if (false === $this->accessDecision->decide($token, [HasBasketVoter::PERMISSION])) {
            return false;
        }

        if (true === $subject instanceof ProductRepresentation) {
            $subject = $this->repository->find($subject->getId());
        }

        $basket = $this->provider->getUserBasket();

        if (true === $this->repository->basketHasProduct($subject, $basket)) {
            return false;
        }

        return $basket->getProducts()->count() < 3;
    }
}
