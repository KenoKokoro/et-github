<?php

namespace App\API\V1\DAL\Github;

class GithubResponseCollection
{
    /**
     * @var int
     */
    private $totalCount;

    /**
     * @var array
     */
    private $items;

    /**
     * @var bool
     */
    private $incompleteResults;

    public function __construct(int $totalCount, array $items, bool $incompleteResults)
    {
        $this->totalCount = $totalCount;
        $this->items = $items;
        $this->incompleteResults = $incompleteResults;
    }

    public function items(): array
    {
        return $this->items;
    }
}
