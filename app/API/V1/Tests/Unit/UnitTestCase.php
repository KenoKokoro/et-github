<?php

namespace ET\API\V1\Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;

class UnitTestCase extends TestCase
{
    protected function setUp(): void
    {
        Carbon::setTestNow(Carbon::createFromFormat('Y-m-d H:i:s', '2019-03-20 10:00:00'));
        parent::setUp();
    }
}
