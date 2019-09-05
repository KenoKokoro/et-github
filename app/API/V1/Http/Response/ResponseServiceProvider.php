<?php

namespace ET\API\V1\Http\Response;

use App\Http\Response\JsonResponseInterface;
use App\Http\Response\ResponseFactoryInterface;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ResponseFactoryInterface::class, ResponseFactory::class);
        $this->app->bind(JsonResponseInterface::class, JsonResponseFactory::class);
    }
}
