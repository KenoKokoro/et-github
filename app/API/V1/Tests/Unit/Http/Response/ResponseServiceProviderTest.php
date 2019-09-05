<?php

namespace ET\API\V1\Tests\Unit\Http\Response;

use App\Http\Response\JsonResponseInterface;
use App\Http\Response\ResponseFactoryInterface;
use ET\API\V1\Http\Response\JsonResponseFactory;
use ET\API\V1\Http\Response\ResponseFactory;
use ET\API\V1\Http\Response\ResponseServiceProvider;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Illuminate\Contracts\Foundation\Application;
use Mockery as m;
use Mockery\MockInterface;

class ResponseServiceProviderTest extends UnitTestCase
{
    /**
     * @var MockInterface|Application
     */
    private $application;

    /**
     * @var ResponseServiceProvider
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->application = m::mock(Application::class);
        $this->fixture = new ResponseServiceProvider($this->application);
        parent::setUp();
    }

    /** @test */
    public function should_register_response_modules(): void
    {
        $this->application
            ->shouldReceive('bind')
            ->once()
            ->with(ResponseFactoryInterface::class, ResponseFactory::class);
        $this->application
            ->shouldReceive('bind')
            ->once()
            ->with(JsonResponseInterface::class, JsonResponseFactory::class);

        $this->fixture->register();
    }
}
