<?php
declare(strict_types=1);

namespace App\Manager;

use App\Model\ModelInterface;

interface DataManagerInterface
{
    public function populate(ModelInterface $model): void;

    public function remove(ModelInterface $model): void;
}
