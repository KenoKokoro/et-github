<?php

namespace ET\API\V1\Tests\Acceptance\Contexts;

use ET\API\V1\Providers\ServiceProvider;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Imbo\BehatApiExtension\Context\ApiContext as BehatApiContext;
use Laravel\Lumen\Application;

class ApiContext extends BehatApiContext
{
    /**
     * @BeforeSuite
     */
    public static function bootstrap(): void
    {
        /** @var Application $app */
        $app = require __DIR__ . '/../../../../../../bootstrap/app.php';
        $app->boot();
        $app->register(ServiceProvider::class);
        $cache = $app->make(CacheRepository::class);
        $cache->clear();
    }
}
