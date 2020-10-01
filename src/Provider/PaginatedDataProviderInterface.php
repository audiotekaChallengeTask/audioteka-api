<?php
declare(strict_types=1);

namespace App\Provider;

use App\Model\AbstractPaginatedCollectionModel;
use App\Model\PaginationRequest;

interface PaginatedDataProviderInterface
{
    public function paginate(PaginationRequest $request): AbstractPaginatedCollectionModel;
}
