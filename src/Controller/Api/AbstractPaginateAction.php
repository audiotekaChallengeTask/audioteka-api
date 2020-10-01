<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Model\AbstractPaginatedCollectionModel;
use App\Model\PaginationRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractPaginateAction extends AbstractApiAction
{
    public function __invoke(PaginationRequest $paginationRequest, Request $request): Response
    {
        $data = $this->getData($paginationRequest, $request);

        return $this->paginatedRepresentationResponse($data, $request);
    }

    abstract protected function getData(PaginationRequest $paginationRequest, Request $request): AbstractPaginatedCollectionModel;
}
