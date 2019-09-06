<?php

namespace ET\API\V1\Tests\Unit\Services\Github\Response\ViewModels;

use ET\API\V1\Services\Github\Response\ViewModels\SearchFileList;
use ET\API\V1\Tests\Unit\UnitTestCase;
use JsonSerializable;

class SearchFileListTest extends UnitTestCase
{
    /**
     * @var SearchFileList
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->fixture = new SearchFileList(['file1', 'file2', 'file3']);
        parent::setUp();
    }

    /** @test */
    public function should_create_search_file_list_instance(): void
    {
        self::assertInstanceOf(SearchFileList::class, $this->fixture);
        self::assertInstanceOf(JsonSerializable::class, $this->fixture);
    }

    /** @test */
    public function should_make_json_response_from_search_file_list_instance(): void
    {
        $actual = json_encode($this->fixture);
        $expected = json_encode(['file1', 'file2', 'file3']);

        self::assertEquals($expected, $actual);
    }
}
