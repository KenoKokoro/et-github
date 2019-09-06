<?php

namespace ET\API\V1\Tests\Unit\DAL;

use ET\API\V1\DAL\DalServiceProvider;
use ET\API\V1\DAL\Github\GithubApi;
use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Illuminate\Contracts\Foundation\Application;
use Mockery as m;
use Mockery\MockInterface;

class DalServiceProviderTest extends UnitTestCase
{
    /**
     * @var MockInterface|Application
     */
    private $application;

    /**
     * @var DalServiceProvider
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->application = m::mock(Application::class);
        $this->fixture = new DalServiceProvider($this->application);
        parent::setUp();
    }

    /** @test */
    public function should_bind_data_access_layers_implementations_to_their_interfaces(): void
    {
        $this->application
            ->shouldReceive('bind')
            ->once()
            ->with(GithubRepository::class, GithubApi::class);

        $this->fixture->register();
    }
}
