<?php

namespace ET\API\V1\Services\Github\DTO;

use Carbon\Carbon;
use ET\API\V1\Service\Github\DTO\CacheableQuery;

class KeywordQuery extends AbstractQuery implements CacheableQuery
{
    private const TTL_MINUTES = 3;

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

    public function getCacheSignature(): string
    {
        return base64_encode($this->getQueryString());
    }

    public function getCacheTtl(): Carbon
    {
        return Carbon::now()->addMinutes(self::TTL_MINUTES);
    }
}
