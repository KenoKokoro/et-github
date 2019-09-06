<?php

namespace ET\API\V1\Services\Github\DTO;

class KeywordQuery extends AbstractQuery
{
    /**
     * @var RepositoryQuery
     */
    private $repositoryQuery;

    /**
     * @var string
     */
    private $keyword;

    public function __construct(RepositoryQuery $repositoryQuery, string $keyword)
    {
        $this->repositoryQuery = $repositoryQuery;
        $this->keyword = $keyword;
    }

    public function getQueryString(): string
    {
        return "{$this->keyword}+{$this->repositoryQuery->getQueryString()}";
    }
}
