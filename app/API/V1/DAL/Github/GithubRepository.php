<?php

namespace ET\API\V1\DAL\Github;

use App\API\V1\DAL\Github\GithubResponseCollection;
use ET\API\V1\Services\Github\DTO\KeywordQuery;
use Github\Exception\ValidationFailedException;

interface GithubRepository
{
    /**
     * @param KeywordQuery $query
     * @return GithubResponseCollection
     * @throws ValidationFailedException
     */
    public function searchCode(KeywordQuery $query): GithubResponseCollection;
}
