<?php

namespace ET\API\V1\Tests\Unit\Http\Response;

use App\Http\Response\JsonResponseInterface;
use App\Http\Response\ResponseFactoryInterface;
use ET\API\V1\Http\Response\ResponseFactory;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Mockery as m;
use Mockery\MockInterface;

class ResponseFactoryTest extends UnitTestCase
{
    /**
     * @var MockInterface|Container
     */
    private $container;

    /**
     * @var ResponseFactory
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->container = m::mock(Container::class);
        $this->fixture = new ResponseFactory($this->container);
        parent::setUp();
    }

    /** @test */
    public function should_create_response_factory_instance(): void
    {
        self::assertInstanceOf(ResponseFactory::class, $this->fixture);
        self::assertInstanceOf(ResponseFactoryInterface::class, $this->fixture);
    }

    /** @test
     * @throws BindingResolutionException
     */
    public function should_return_json_response_instance(): void
    {
        $instance = m::mock(JsonResponseInterface::class);

        $this->container
            ->shouldReceive('make')
            ->once()
            ->with(JsonResponseInterface::class)
            ->andReturn($instance);

        $actual = $this->fixture->json();
        self::assertInstanceOf(JsonResponseInterface::class, $actual);
    }
}
