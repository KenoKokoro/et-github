<?php

namespace ET\API\V1\Services\Github;

use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Services\Github\DTO\KeywordQuery;
use ET\API\V1\Services\Github\Response\ViewModels\SearchFileList;
use Illuminate\Support\Collection;

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

    /**
     * @param KeywordQuery $query
     * @return SearchFileList
     */
    public function searchFiles(KeywordQuery $query): SearchFileList
    {
        $response = $this->repository->searchCode($query);
        $files = Collection::make($response->items())->pluck('path');

        return SearchFileList::make($files->toArray());
    }

    /**
     * @return GithubDtoFactory
     */
    public function dtoFactory(): GithubDtoFactory
    {
        return $this->dtoFactory;
    }
}
