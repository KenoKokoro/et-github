<?php

namespace ET\API\V1\Tests\Unit\Service\Github\DTO;

use Carbon\Carbon;
use ET\API\V1\Service\Github\DTO\CacheableQuery;
use ET\API\V1\Services\Github\DTO\AbstractQuery;
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
        parent::setUp();
        $this->repository = m::mock(RepositoryQuery::class);
        $this->fixture = new KeywordQuery($this->repository, 'keyword');
    }

    /** @test */
    public function should_create_keyword_query_instance(): void
    {
        self::assertInstanceOf(KeywordQuery::class, $this->fixture);
        self::assertInstanceOf(AbstractQuery::class, $this->fixture);
        self::assertInstanceOf(CacheableQuery::class, $this->fixture);
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

    /** @test */
    public function should_return_keyword_cache_signature_string(): void
    {
        $this->repository
            ->shouldReceive('getQueryString')
            ->once()
            ->andReturn('repo:owner/repo');
        $expected = base64_encode("keyword+repo:owner/repo");

        self::assertEquals($expected, $this->fixture->getCacheSignature());
    }

    /** @test */
    public function should_return_keyword_cache_time_to_live(): void
    {
        $expected = Carbon::now()->addMinutes(3);

        self::assertEquals($expected, $this->fixture->getCacheTtl());
    }
}
