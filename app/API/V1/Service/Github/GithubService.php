<?php

namespace ET\API\V1\Service\Github;

use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Service\Github\DTO\KeywordQuery;

class GithubService
{
    /**
     * @var GithubRepository
     */
    private $repository;

    /**
     * @var GithubDtoFactory
     */
    private $dtoFactory;

    public function __construct(GithubRepository $repository, GithubDtoFactory $dtoFactory)
    {
        $this->repository = $repository;
        $this->dtoFactory = $dtoFactory;
    }

    public function searchFiles(KeywordQuery $query): array
    {
        return $this->repository->searchCode($query)->toArray();
    }

    public function dtoFactory(): GithubDtoFactory
    {
        return $this->dtoFactory;
    }
}
