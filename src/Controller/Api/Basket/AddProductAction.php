<?php
declare(strict_types=1);

namespace App\Controller\Api\Basket;

use App\Controller\Api\AbstractApiAction;
use App\Entity\Basket;
use App\Entity\Product;
use App\Manager\BasketDataManager;
use App\Provider\BasketDataProvider;
use App\Provider\ProductDataProvider;
use App\Security\Voter\AddProductToBasketVoter;
use App\Security\Voter\HasBasketVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AddProductAction extends AbstractApiAction
{
    private BasketDataProvider  $basketProvider;
    private ProductDataProvider $productProvider;
    private BasketDataManager   $basketManager;

    public function __construct(BasketDataProvider $basketProvider, ProductDataProvider $productProvider, BasketDataManager $basketManager)
    {
        $this->basketProvider  = $basketProvider;
        $this->productProvider = $productProvider;
        $this->basketManager   = $basketManager;
    }

    public function __invoke(Request $request, int $id): Response
    {
        /** @var Product $product */
        $product = $this->productProvider->single($id);

        if (false === $this->authorizationChecker->isGranted(HasBasketVoter::PERMISSION)) {
            print_r(unserialize(serialize($this->basketProvider->findAll())));
            die;
            throw new BadRequestHttpException('There\'s no basket.');
        }

        if (false === $this->authorizationChecker->isGranted(AddProductToBasketVoter::PERMISSION, $product)) {
            throw new BadRequestHttpException('Unable to add more items to basket.');
        }

        $basket = $this->basketProvider->getUserBasket();
        $this->basketManager->addProductToBasket($product, $basket);
        $this->basketManager->populate($basket);

        return $this->representationResponse($basket, Response::HTTP_ACCEPTED);
    }

    protected function getModelClassName(): string
    {
        return Basket::class;
    }
}

