<?php
declare(strict_types=1);

namespace App\Model;

class PaginationRequest
{
    private int $page;
    private int $limit;

    public function __construct(int $page = 1, int $limit = 3)
    {
        $this->page  = $page;
        $this->limit = $limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
