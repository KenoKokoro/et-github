<?php

namespace ET\API\V1\Tests\Unit\DAL\Github;

use ET\API\V1\DAL\Github\GithubApi;
use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Service\Github\DTO\KeywordQuery;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Github\Api\Search;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Support\Collection;
use Mockery as m;
use Mockery\MockInterface;

class GithubApiTest extends UnitTestCase
{
    /**
     * @var MockInterface|GitHubManager
     */
    private $github;

    /**
     * @var GithubApi
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->github = m::mock(GitHubManager::class);
        $this->fixture = new GithubApi($this->github);
        parent::setUp();
    }

    /** @test */
    public function should_create_github_api_instance(): void
    {
        self::assertInstanceOf(GithubApi::class, $this->fixture);
        self::assertInstanceOf(GithubRepository::class, $this->fixture);
    }

    /** @test */
    public function should_search_in_github_code_api(): void
    {
        $keyword = m::mock(KeywordQuery::class);
        $keyword
            ->shouldReceive('getQueryString')
            ->once()
            ->andReturn('word+repo:username/repository');
        $searchMock = m::mock(Search::class);
        $searchMock
            ->shouldReceive('code')
            ->once()
            ->with('word+repo:username/repository')
            ->andReturn(['item1', 'item2']);
        $this->github
            ->shouldReceive('search')
            ->once()
            ->andReturn($searchMock);

        $collection = $this->fixture->searchCode($keyword);

        self::assertInstanceOf(Collection::class, $collection);
    }
}
