<?php
declare(strict_types=1);

namespace App\Controller\Api\Basket;

use App\Controller\Api\AbstractApiAction;
use App\Entity\Basket;
use App\Model\ProductCollectionModel;
use App\Provider\BasketDataProvider;
use App\Provider\ProductDataProvider;
use App\Security\Voter\HasBasketVoter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductsAction extends AbstractApiAction
{
    private BasketDataProvider  $basketProvider;
    private ProductDataProvider $productProvider;

    public function __construct(BasketDataProvider $basketProvider, ProductDataProvider $productProvider)
    {
        $this->basketProvider  = $basketProvider;
        $this->productProvider = $productProvider;
    }

    public function __invoke(): Response
    {
        if (false === $this->authorizationChecker->isGranted(HasBasketVoter::PERMISSION)) {
            throw new BadRequestHttpException('There\'s no basket.');
        }

        $basket   = $this->basketProvider->getUserBasket();
        $products = $this->productProvider->getBasketProducts($basket);
        $model    = new ProductCollectionModel($products);

        return $this->representationResponse($model);
    }

    protected function getModelClassName(): string
    {
        return Basket::class;
    }
}
