<?php

namespace ET\API\V1\Tests\Unit\DAL\Github;

use App\API\V1\DAL\Github\GithubResponseCollection;
use ET\API\V1\Tests\Unit\UnitTestCase;

class GithubResponseCollectionTest extends UnitTestCase
{
    /**
     * @var GithubResponseCollection
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->fixture = new GithubResponseCollection(0, [['item1'], ['item2']], false);
        parent::setUp();
    }

    /** @test */
    public function should_return_items_in_github_response_collection(): void
    {
        self::assertEquals([['item1'], ['item2']], $this->fixture->items());
    }
}
