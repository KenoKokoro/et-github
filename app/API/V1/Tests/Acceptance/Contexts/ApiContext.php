<?php

namespace ET\API\V1\Tests\Acceptance\Contexts;

use ET\API\V1\Providers\ServiceProvider;
use ET\API\V1\Services\Github\GithubDtoFactory;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Imbo\BehatApiExtension\Context\ApiContext as BehatApiContext;
use Laravel\Lumen\Application;
use PHPUnit\Framework\Assert;
use Psr\SimpleCache\InvalidArgumentException;

class ApiContext extends BehatApiContext
{
    /**
     * @var Application
     */
    private static $app;

    /**
     * @BeforeSuite
     */
    public static function bootstrap(): void
    {
        /** @var Application $app */
        $app = require __DIR__ . '/../../../../../../bootstrap/app.php';
        $app->boot();
        $app->register(ServiceProvider::class);
        static::$app = $app;
        $cache = $app->make(CacheRepository::class);
        $cache->clear();
    }

    /**
     * @AfterSuite
     */
    public static function destroy(): void
    {
        $cache = static::$app->make(CacheRepository::class);
        $cache->clear();
    }

    /**
     * @Given /^the cache key for keyword query "([^"]*)" owner "([^"]*)" repository "([^"]*)" does not exists$/
     * @param string $keyword
     * @param string $owner
     * @param string $repository
     * @throws InvalidArgumentException
     */
    public function theCacheKeyForKeywordQueryDoesNotExists(string $keyword, string $owner, string $repository): void
    {
        $cache = static::$app->make(CacheRepository::class);
        $factory = static::$app->make(GithubDtoFactory::class);
        $instance = $factory->makeKeywordQueryFromAttributes($keyword, $owner, $repository);

        Assert::assertFalse($cache->has($instance->getCacheSignature()));
    }

    /**
     * @Given /^the cache key for keyword query "([^"]*)" owner "([^"]*)" repository "([^"]*)" exists$/
     * @param string $keyword
     * @param string $owner
     * @param string $repository
     * @throws InvalidArgumentException
     */
    public function theCacheKeyForKeywordQueryExists(string $keyword, string $owner, string $repository): void
    {
        $cache = static::$app->make(CacheRepository::class);
        $factory = static::$app->make(GithubDtoFactory::class);
        $instance = $factory->makeKeywordQueryFromAttributes($keyword, $owner, $repository);

        Assert::assertTrue($cache->has($instance->getCacheSignature()));
    }
}
