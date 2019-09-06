<?php

namespace ET\API\V1\Tests\Unit\Service\Github;

use ET\API\V1\Services\Github\DTO\AbstractQuery;
use ET\API\V1\Services\Github\DTO\KeywordQuery;
use ET\API\V1\Services\Github\DTO\RepositoryQuery;
use ET\API\V1\Services\Github\GithubDtoFactory;
use ET\API\V1\Tests\Unit\UnitTestCase;

class GithubDtoFactoryTest extends UnitTestCase
{
    /**
     * @var GithubDtoFactory
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->fixture = new GithubDtoFactory;
        parent::setUp();
    }

    /** @test */
    public function should_return_keyword_query_instance(): void
    {
        $actual = $this->fixture->makeKeywordQueryFromAttributes('keyword', 'owner', 'repo');

        self::assertInstanceOf(KeywordQuery::class, $actual);
        self::assertInstanceOf(AbstractQuery::class, $actual);
    }

    /** @test */
    public function should_return_repository_query_instance(): void
    {
        $actual = $this->fixture->makeRepositoryQueryFromAttributes('owner', 'repo');

        self::assertInstanceOf(RepositoryQuery::class, $actual);
        self::assertInstanceOf(AbstractQuery::class, $actual);
    }
}
