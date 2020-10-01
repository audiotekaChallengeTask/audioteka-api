<?php
declare(strict_types=1);

namespace App\Model;

abstract class AbstractPaginatedCollectionModel extends AbstractCollectionModel
{
    private int $page;
    private int $limit;
    private int $total;

    public function __construct(array $resources, int $page, int $limit, int $total)
    {
        parent::__construct($resources);

        $this->page  = $page;
        $this->limit = $limit;
        $this->total = $total;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
