<?php

namespace ET\API\V1\DAL\Github;

use ET\API\V1\Service\Github\DTO\KeywordQuery;
use Illuminate\Support\Collection;

interface GithubRepository
{
    /**
     * @param KeywordQuery $query
     * @return Collection
     */
    public function searchCode(KeywordQuery $query): Collection;
}
