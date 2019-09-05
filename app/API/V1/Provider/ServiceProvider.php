<?php

namespace ET\API\V1\Provider;

use ET\API\V1\Http\Response\ResponseServiceProvider;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function register(): void
    {
        $this->app->register(ResponseServiceProvider::class);
    }
}
