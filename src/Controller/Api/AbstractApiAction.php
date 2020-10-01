<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Form\ApiFormHandler;
use App\Manager\DataManagerInterface;
use App\Model\AbstractPaginatedCollectionModel;
use App\Model\ModelInterface;
use App\Provider\DataProviderInterface;
use App\Transformer\RepresentationTransformer;
use Hateoas\Representation\PaginatedRepresentation;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

abstract class AbstractApiAction
{
    protected RepresentationTransformer     $transformer;
    protected SerializerInterface           $serializer;
    protected FormFactoryInterface          $formFactory;
    protected ApiFormHandler                $formHandler;
    protected AuthorizationCheckerInterface $authorizationChecker;

    abstract protected function getModelClassName(): string;

    public function setTransformer(RepresentationTransformer $transformer): void
    {
        $this->transformer = $transformer;
    }

    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }

    public function setFormHandler(ApiFormHandler $formHandler): void
    {
        $this->formHandler = $formHandler;
    }

    public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker): void
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    protected function representationResponse(ModelInterface $model, int $status = Response::HTTP_OK): Response
    {
        $representation           = $this->transformer->transform($model);
        $serializedRepresentation = $this->serializer->serialize($representation, 'json');

        return new JsonResponse($serializedRepresentation, $status, [], true);
    }

    protected function paginatedRepresentationResponse(AbstractPaginatedCollectionModel $model, Request $request): Response
    {
        $representation           = new PaginatedRepresentation(
            $this->transformer->transform($model),
            $request->get('_route'),
            $request->get('_route_params'),
            $model->getPage(),
            $model->getLimit(),
            (int) (0 === $model->getTotal() ? 0 : ceil($model->getTotal() / $model->getLimit())),
            'page',
            'limit',
            false,
            $model->getTotal()
        );
        $serializedRepresentation = $this->serializer->serialize($representation, 'json');

        return new JsonResponse($serializedRepresentation, Response::HTTP_OK, [], true);
    }

    protected function emptyJsonResponseWithStatus(int $status = Response::HTTP_OK): Response
    {
        return new JsonResponse(null, $status);
    }

    protected function emptyResponseWithStatus(int $status = Response::HTTP_OK): Response
    {
        return new Response('', $status);
    }
}
