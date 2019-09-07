<?php

namespace ET\API\V1\Services\Github;

use App\Exceptions\HttpResponseException;
use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Service\Github\DTO\CacheableQuery;
use ET\API\V1\Service\Github\Exceptions\GithubBadRequest;
use ET\API\V1\Service\Github\Exceptions\InvalidSearchParameterException;
use ET\API\V1\Services\Github\DTO\KeywordQuery;
use ET\API\V1\Services\Github\Response\ViewModels\SearchFileList;
use Exception;
use Github\Exception\ValidationFailedException;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Psr\SimpleCache\InvalidArgumentException;

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

    /**
     * @var CacheRepository
     */
    private $cache;

    public function __construct(
        GithubRepository $repository,
        GithubDtoFactory $dtoFactory,
        CacheRepository $cache
    ) {
        $this->repository = $repository;
        $this->dtoFactory = $dtoFactory;
        $this->cache = $cache;
    }

    /**
     * @param KeywordQuery $query
     * @return SearchFileList
     * @throws HttpResponseException
     */
    public function searchFiles(KeywordQuery $query): SearchFileList
    {
        $cachedResponse = $this->getCachedResponse($query);
        if ($cachedResponse !== null) {
            return SearchFileList::make($cachedResponse);
        }

        try {
            $response = $this->repository->searchCode($query);
        } catch (ValidationFailedException $exception) {
            throw new InvalidSearchParameterException;
        } catch (Exception $exception) {
            throw new GithubBadRequest($exception->getMessage());
        }

        $files = Collection::make($response->items())->pluck('path');
//        $this->cache->put($query->getCacheSignature(), json_encode($files), $query->getCacheTtl());

        return SearchFileList::make($files->toArray());
    }

    /**
     * @return GithubDtoFactory
     */
    public function dtoFactory(): GithubDtoFactory
    {
        return $this->dtoFactory;
    }

    /**
     * @param CacheableQuery $query
     * @return array|null
     */
    private function getCachedResponse(CacheableQuery $query): ?array
    {
        $key = $query->getCacheSignature();
        try {
            if ($this->cache->has($key)) {
                return json_decode($this->cache->get($key), true);
            }
        } catch (InvalidArgumentException $e) {
            return null;
        }

        return null;
    }
}
