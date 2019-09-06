<?php

namespace ET\API\V1\Tests\Unit\Service\Github;

use App\API\V1\DAL\Github\GithubResponseCollection;
use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Services\Github\DTO\KeywordQuery;
use ET\API\V1\Services\Github\GithubDtoFactory;
use ET\API\V1\Services\Github\GithubService;
use ET\API\V1\Services\Github\Response\ViewModels\SearchFileList;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Illuminate\Support\Collection;
use Mockery as m;
use Mockery\MockInterface;

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
     * @var GithubService
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->repository = m::mock(GithubRepository::class);
        $this->dtoFactory = m::mock(GithubDtoFactory::class);
        $this->fixture = new GithubService($this->repository, $this->dtoFactory);
        parent::setUp();
    }

    /** @test */
    public function should_search_files_from_github_repository(): void
    {
        $query = m::mock(KeywordQuery::class);
        $response = m::mock(GithubResponseCollection::class);
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

    /** @test */
    public function should_return_github_dto_factory_instance(): void
    {
        self::assertEquals($this->dtoFactory, $this->fixture->dtoFactory());
    }
}
