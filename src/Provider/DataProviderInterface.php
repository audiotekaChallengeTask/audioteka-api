<?php
declare(strict_types=1);

namespace App\Provider;

use App\Model\ModelInterface;

interface DataProviderInterface
{
    public function single(int $id): ?ModelInterface;

    public function findOneBy(array $parameters = []): ?ModelInterface;

    public function findMultipleBy(array $parameters = []): array;

    public function newInstance(): ModelInterface;
}
