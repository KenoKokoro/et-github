<?php

namespace ET\API\V1\Services\Github;

use ET\API\V1\Services\Github\DTO\KeywordQuery;
use ET\API\V1\Services\Github\DTO\RepositoryQuery;

class GithubDtoFactory
{
    /**
     * @param string $keyword
     * @param string $owner
     * @param string $repository
     * @return KeywordQuery
     */
    public function makeKeywordQueryFromAttributes(string $keyword, string $owner, string $repository): KeywordQuery
    {
        $repositoryQuery = $this->makeRepositoryQueryFromAttributes($owner, $repository);

        return new KeywordQuery($repositoryQuery, $keyword);
    }

    /**
     * @param string $owner
     * @param string $repository
     * @return RepositoryQuery
     */
    public function makeRepositoryQueryFromAttributes(string $owner, string $repository): RepositoryQuery
    {
        return new RepositoryQuery($owner, $repository);
    }
}
