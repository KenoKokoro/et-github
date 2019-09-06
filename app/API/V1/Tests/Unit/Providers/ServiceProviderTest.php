<?php

namespace ET\API\V1\Tests\Unit\Providers;

use ET\API\V1\DAL\DalServiceProvider;
use ET\API\V1\Http\Response\ResponseServiceProvider;
use ET\API\V1\Providers\ServiceProvider;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Illuminate\Contracts\Foundation\Application;
use Mockery as m;
use Mockery\MockInterface;

class ServiceProviderTest extends UnitTestCase
{
    /**
     * @var MockInterface|Application
     */
    private $application;

    /**
     * @var ServiceProvider
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->application = m::mock(Application::class);
        $this->fixture = new ServiceProvider($this->application);
        parent::setUp();
    }

    /** @test */
    public function should_register_all_v1_service_providers(): void
    {
        $this->application
            ->shouldReceive('register')
            ->once()
            ->with(ResponseServiceProvider::class);
        $this->application
            ->shouldReceive('register')
            ->once()
            ->with(DalServiceProvider::class);

        $this->fixture->register();
    }
}
