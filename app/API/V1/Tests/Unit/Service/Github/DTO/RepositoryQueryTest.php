<?php

namespace ET\API\V1\Tests\Unit\Service\Github\DTO;

use ET\API\V1\Service\Github\DTO\RepositoryQuery;
use ET\API\V1\Tests\Unit\UnitTestCase;

class RepositoryQueryTest extends UnitTestCase
{
    /**
     * @var RepositoryQuery
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->fixture = new RepositoryQuery('owner', 'repo-123');
        parent::setUp();
    }

    /** @test */
    public function should_return_repository_query_string(): void
    {
        self::assertEquals('repo:owner/repo-123', $this->fixture->getQueryString());
    }
}
