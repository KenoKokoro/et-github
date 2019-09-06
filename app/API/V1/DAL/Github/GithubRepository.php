<?php

namespace ET\API\V1\DAL\Github;

use App\API\V1\DAL\Github\GithubResponseCollection;
use ET\API\V1\Services\Github\DTO\KeywordQuery;

interface GithubRepository
{
    /**
     * @param KeywordQuery $query
     * @return GithubResponseCollection
     */
    public function searchCode(KeywordQuery $query): GithubResponseCollection;
}
