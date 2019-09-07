<?php

namespace ET\API\V1\Tests\Unit\Service\Github;

use App\API\V1\DAL\Github\GithubResponseCollection;
use App\Exceptions\HttpResponseException;
use Carbon\Carbon;
use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Service\Github\Exceptions\GithubBadRequest;
use ET\API\V1\Service\Github\Exceptions\InvalidSearchParameterException;
use ET\API\V1\Services\Github\DTO\KeywordQuery;
use ET\API\V1\Services\Github\GithubDtoFactory;
use ET\API\V1\Services\Github\GithubService;
use ET\API\V1\Services\Github\Response\ViewModels\SearchFileList;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Github\Exception\ApiLimitExceedException;
use Github\Exception\ValidationFailedException;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Mockery as m;
use Mockery\MockInterface;
use Symfony\Component\Cache\Exception\InvalidArgumentException;

class GithubServiceTest extends UnitTestCase
{
    /**
     * @var MockInterface|GithubRepository
     */
    private $repository;

    /**
     * @var MockInterface|GithubDtoFactory
     */
    private $dtoFactory;

    /**
     * @var MockInterface|CacheRepository
     */
    private $cache;

    /**
     * @var Carbon
     */
    private $ttlStub;

    /**
     * @var GithubService
     */
    private $fixture;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = m::mock(GithubRepository::class);
        $this->dtoFactory = m::mock(GithubDtoFactory::class);
        $this->cache = m::mock(CacheRepository::class);
        $this->ttlStub = Carbon::now()->addMinutes(3);
        $this->fixture = new GithubService($this->repository, $this->dtoFactory, $this->cache);
    }

    /** @test
     * @throws HttpResponseException
     */
    public function should_throw_invalid_search_exception_if_validation_fails_from_github(): void
    {
        self::expectException(InvalidSearchParameterException::class);
        $query = m::mock(KeywordQuery::class);

        $query
            ->shouldReceive('getCacheSignature')
            ->once()
            ->andReturn('cache-key');
        $this->cache
            ->shouldReceive('has')
            ->once()
            ->with('cache-key')
            ->andReturn(false);
        $this->repository
            ->shouldReceive('searchCode')
            ->once()
            ->with($query)
            ->andThrow(new ValidationFailedException);

        $this->fixture->searchFiles($query);
    }

    /** @test
     * @throws HttpResponseException
     */
    public function should_throw_bad_request_if_there_is_some_exception_from_github(): void
    {
        self::expectException(GithubBadRequest::class);
        $query = m::mock(KeywordQuery::class);

        $query
            ->shouldReceive('getCacheSignature')
            ->once()
            ->andReturn('cache-key');
        $this->cache
            ->shouldReceive('has')
            ->once()
            ->with('cache-key')
            ->andReturn(false);
        $this->repository
            ->shouldReceive('searchCode')
            ->once()
            ->with($query)
            ->andThrow(new ApiLimitExceedException);

        $this->fixture->searchFiles($query);
    }

    /** @test
     * @throws HttpResponseException
     */
    public function should_search_files_from_github_repository_when_there_is_no_cache_hit(): void
    {
        $query = m::mock(KeywordQuery::class);
        $response = m::mock(GithubResponseCollection::class);

        $query
            ->shouldReceive('getCacheSignature')
            ->twice()
            ->andReturn('cache-key');
        $query
            ->shouldReceive('getCacheTtl')
            ->once()
            ->andReturn($this->ttlStub);
        $this->cache
            ->shouldReceive('has')
            ->once()
            ->with('cache-key')
            ->andReturn(false);
        $this->cache
            ->shouldReceive('put')
            ->once()
            ->with('cache-key', json_encode(['path1', 'path2']), $this->ttlStub);
        $response
            ->shouldReceive('items')
            ->once()
            ->andReturn([['path' => 'path1'], ['path' => 'path2']]);
        $this->repository
            ->shouldReceive('searchCode')
            ->once()
            ->with($query)
            ->andReturn($response);

        $actual = $this->fixture->searchFiles($query);
        self::assertInstanceOf(SearchFileList::class, $actual);
    }

    /** @test
     * @throws HttpResponseException
     */
    public function should_search_files_from_github_repository_when_there_is_error_when_reading_from_cache(): void
    {
        $query = m::mock(KeywordQuery::class);
        $response = m::mock(GithubResponseCollection::class);

        $query
            ->shouldReceive('getCacheSignature')
            ->twice()
            ->andReturn('cache-key');
        $query
            ->shouldReceive('getCacheTtl')
            ->once()
            ->andReturn($this->ttlStub);
        $this->cache
            ->shouldReceive('has')
            ->once()
            ->with('cache-key')
            ->andThrow(new InvalidArgumentException);
        $this->cache
            ->shouldReceive('put')
            ->once()
            ->with('cache-key', json_encode(['path1', 'path2']), $this->ttlStub);
        $response
            ->shouldReceive('items')
            ->once()
            ->andReturn([['path' => 'path1'], ['path' => 'path2']]);
        $this->repository
            ->shouldReceive('searchCode')
            ->once()
            ->with($query)
            ->andReturn($response);

        $actual = $this->fixture->searchFiles($query);
        self::assertInstanceOf(SearchFileList::class, $actual);
    }

    /** @test
     * @throws HttpResponseException
     */
    public function should_search_files_from_github_repository_and_return_them_from_cache_when_there_is_hit(): void
    {
        $query = m::mock(KeywordQuery::class);

        $query
            ->shouldReceive('getCacheSignature')
            ->once()
            ->andReturn('cache-key');
        $this->cache
            ->shouldReceive('has')
            ->once()
            ->with('cache-key')
            ->andReturnTrue();
        $this->cache
            ->shouldReceive('get')
            ->once()
            ->with('cache-key')
            ->andReturn(json_encode(['file1', 'file2']));

        $actual = $this->fixture->searchFiles($query);
        self::assertInstanceOf(SearchFileList::class, $actual);
    }

    /** @test */
    public function should_return_github_dto_factory_instance(): void
    {
        self::assertEquals($this->dtoFactory, $this->fixture->dtoFactory());
    }
}
