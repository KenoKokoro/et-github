<?php

namespace ET\API\V1\Providers;

use ET\API\V1\DAL\DalServiceProvider;
use ET\API\V1\Http\Response\ResponseServiceProvider;
use ET\API\V1\Tests\Acceptance\Mocks\MockServiceProvider;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function register(): void
    {
        $this->app->register(ResponseServiceProvider::class);
        $this->app->register(DalServiceProvider::class);

        if ($this->app->environment('behat')) {
            $this->app->register(MockServiceProvider::class);
        }
    }
}
