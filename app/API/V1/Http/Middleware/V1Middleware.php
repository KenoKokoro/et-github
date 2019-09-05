<?php

namespace ET\API\V1\Http\Middleware;

use Closure;
use ET\API\V1\Provider\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class V1Middleware
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle(Request $request, Closure $next): JsonResponse
    {
        /** @var Application $application */
        $application = $this->container->get('app');
        $application->register(ServiceProvider::class);

        return $next($request);
    }
}
