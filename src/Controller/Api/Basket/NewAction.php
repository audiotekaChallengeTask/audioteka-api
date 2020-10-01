<?php
declare(strict_types=1);

namespace App\Controller\Api\Basket;

use App\Controller\Api\AbstractFormAction;
use App\Entity\Basket;
use App\Form\Type\Basket\NewType;
use App\Manager\BasketDataManager;
use App\Model\ModelInterface;
use App\Provider\BasketDataProvider;
use App\Security\Voter\CreateNewBasketVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class NewAction extends AbstractFormAction
{
    private BasketDataProvider $basketProvider;
    private BasketDataManager  $basketManager;

    public function __construct(BasketDataProvider $basketProvider, BasketDataManager $basketManager)
    {
        $this->basketProvider = $basketProvider;
        $this->basketManager  = $basketManager;
    }

    protected function getResponseStatusCode(): int
    {
        return Response::HTTP_CREATED;
    }

    protected function postHandle(ModelInterface $model): void
    {
        $this->basketManager->populate($model);
    }

    protected function getMethod(): string
    {
        return Request::METHOD_POST;
    }

    protected function getFormClassName(): string
    {
        return NewType::class;
    }

    protected function getModel(Request $request): ModelInterface
    {
        return $this->basketProvider->newInstance();
    }

    protected function getModelClassName(): string
    {
        return Basket::class;
    }

    protected function preCreateForm(Request $request): ?Response
    {
        if (false === $this->authorizationChecker->isGranted(CreateNewBasketVoter::PERMISSION)) {
            throw new BadRequestHttpException('Basket cannot be created.');
        }

        return null;
    }
}
