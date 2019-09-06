<?php

namespace ET\API\V1\Tests\Unit\Service\Github;

use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Service\Github\DTO\KeywordQuery;
use ET\API\V1\Service\Github\GithubDtoFactory;
use ET\API\V1\Service\Github\GithubService;
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
        $this->repository
            ->shouldReceive('searchCode')
            ->once()
            ->with($query)
            ->andReturn(new Collection());

        $actual = $this->fixture->searchFiles($query);
        self::assertEquals([], $actual);
    }

    /** @test */
    public function should_return_github_dto_factory_instance(): void
    {
        self::assertEquals($this->dtoFactory, $this->fixture->dtoFactory());
    }
}
