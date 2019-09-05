<?php

namespace ET\API\V1\Http\Response;

use App\Http\Response\JsonResponseInterface;
use App\Http\Response\ResponseFactoryInterface;
use Illuminate\Contracts\Container\Container;

class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function json(): JsonResponseInterface
    {
        return $this->container->make(JsonResponseInterface::class);
    }
}
