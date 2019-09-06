<?php

namespace App\Providers;

use ET\API\V1\Exceptions\Handler;
use ET\API\V1\Providers\ServiceProvider as V1ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->register(RedisServiceProvider::class);

        /** @var Request $request */
        $request = $this->app->get('request');
        if ($request->segment(1) === 'v1') {
            $this->app->register(V1ServiceProvider::class);
        }

        // Use the exception handler from v1 as default
        $this->app->singleton(ExceptionHandler::class, Handler::class);
    }
}
