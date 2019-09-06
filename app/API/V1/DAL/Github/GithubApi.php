<?php

namespace ET\API\V1\DAL\Github;

use ET\API\V1\Service\Github\DTO\KeywordQuery;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Support\Collection;

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

    public function searchCode(KeywordQuery $query): Collection
    {
        return Collection::make($this->github->search()->code($query->getQueryString()));
    }
}
