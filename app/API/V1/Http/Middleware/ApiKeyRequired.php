<?php

namespace ET\API\V1\Http\Middleware;

use App\API\V1\Exceptions\ApiKeyIsNotSet;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiKeyRequired
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Closure $next
     * @param Request $request
     * @return JsonResponse
     * @throws ApiKeyIsNotSet
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $this->validate($apiKey = $this->config->get('api-keys.v1', null));
        $value = $request->headers->get('authorization', null);

        if ($value !== "Bearer {$apiKey}") {
            throw new AuthenticationException;
        }

        return $next($request);
    }

    /**
     * @param null|string $apiKey
     * @throws ApiKeyIsNotSet
     */
    private function validate(?string $apiKey): void
    {
        if (empty($apiKey)) {
            throw new ApiKeyIsNotSet;
        }
    }
}
