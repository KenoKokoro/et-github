<?php

namespace ET\API\V1\Tests\Unit\Http\Middleware;

use App\API\V1\Exceptions\ApiKeyIsNotSet;
use ET\API\V1\Http\Middleware\ApiKeyRequired;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery as m;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\HeaderBag;

class ApiKeyRequiredTest extends UnitTestCase
{
    /**
     * @var MockInterface|HeaderBag
     */
    private $headers;

    /**
     * @var MockInterface|Request
     */
    private $request;

    /**
     * @var MockInterface|Config
     */
    private $config;

    /**
     * @var ApiKeyRequired
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->headers = m::mock(HeaderBag::class);
        $this->request = m::mock(Request::class);
        $this->request->headers = $this->headers;
        $this->config = m::mock(Config::class);
        $this->fixture = new ApiKeyRequired($this->config);
        parent::setUp();
    }

    /**
     * @test
     * @throws Exception
     */
    public function should_throw_exception_if_api_key_is_not_set(): void
    {
        self::expectException(ApiKeyIsNotSet::class);
        $this->config
            ->shouldReceive('get')
            ->once()
            ->with('api-keys.v1', null)
            ->andReturn(null);
        $this->fixture->handle(
            $this->request,
            function(Request $request) {
            }
        );
    }

    /**
     * @test
     * @throws Exception
     */
    public function should_throw_exception_if_invalid_api_key_is_provided(): void
    {
        self::expectException(AuthenticationException::class);
        $this->config
            ->shouldReceive('get')
            ->once()
            ->with('api-keys.v1', null)
            ->andReturn('test-key');
        $this->headers
            ->shouldReceive('get')
            ->once()
            ->with('authorization', null)
            ->andReturn('bad-test-key');

        $this->fixture->handle(
            $this->request,
            function(Request $request) {
            }
        );
    }

    /**
     * @test
     * @throws Exception
     */
    public function should_return_json_response_if_api_keys_match(): void
    {
        $this->config
            ->shouldReceive('get')
            ->once()
            ->with('api-keys.v1', null)
            ->andReturn('test-key');
        $this->headers
            ->shouldReceive('get')
            ->once()
            ->with('authorization', null)
            ->andReturn('Bearer test-key');

        $actual = $this->fixture->handle(
            $this->request,
            function(Request $request) {
                return m::mock(JsonResponse::class);
            }
        );

        self::assertInstanceOf(JsonResponse::class, $actual);
    }
}
