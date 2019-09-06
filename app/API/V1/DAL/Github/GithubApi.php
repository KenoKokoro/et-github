<?php

namespace ET\API\V1\DAL\Github;

use App\API\V1\DAL\Github\GithubResponseCollection;
use ET\API\V1\Services\Github\DTO\KeywordQuery;
use GrahamCampbell\GitHub\GitHubManager;

class GithubApi implements GithubRepository
{
    /**
     * @var GitHubManager
     */
    private $github;

    public function __construct(GitHubManager $github)
    {
        $this->github = $github;
    }

    public function searchCode(KeywordQuery $query): GithubResponseCollection
    {
        $response = $this->github->search()->code($query->getQueryString());

        return new GithubResponseCollection(
            $response['total_count'],
            $response['items'],
            $response['incomplete_results']
        );
    }
}
