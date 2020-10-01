<?php
declare(strict_types=1);

namespace App\Controller\Api\Basket;

use App\Controller\Api\AbstractSingleAction;
use App\Entity\Basket;
use App\Model\ModelInterface;
use App\Provider\BasketDataProvider;
use App\Security\Voter\HasBasketVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SingleAction extends AbstractSingleAction
{
    private BasketDataProvider $provider;

    public function __construct(BasketDataProvider $provider)
    {
        $this->provider = $provider;
    }

    protected function loadModel(Request $request): ?ModelInterface
    {
        if (false === $this->authorizationChecker->isGranted(HasBasketVoter::PERMISSION)) {
            throw new BadRequestHttpException('There\'s no basket.');
        }

        return $this->provider->getUserBasket();
    }

    protected function getModelClassName(): string
    {
        return Basket::class;
    }
}
