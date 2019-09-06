<?php

namespace ET\API\V1\Tests\Unit\Service\Github\DTO;

use ET\API\V1\Services\Github\DTO\KeywordQuery;
use ET\API\V1\Services\Github\DTO\RepositoryQuery;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Mockery as m;
use Mockery\MockInterface;

class KeywordQueryTest extends UnitTestCase
{
    /**
     * @var MockInterface|RepositoryQuery
     */
    private $repository;

    /**
     * @var KeywordQuery
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->repository = m::mock(RepositoryQuery::class);
        $this->fixture = new KeywordQuery($this->repository, 'keyword');
        parent::setUp();
    }

    /** @test */
    public function should_return_keyword_query_string(): void
    {
        $this->repository
            ->shouldReceive('getQueryString')
            ->once()
            ->andReturn('repo:owner/repo');
        self::assertEquals('keyword+repo:owner/repo', $this->fixture->getQueryString());
    }
}
