<?php

namespace App\Http\Response;

use Illuminate\Contracts\Container\BindingResolutionException;

interface ResponseFactoryInterface
{
    /**
     * Return json response
     * @return JsonResponseInterface
     * @throws BindingResolutionException
     */
    public function json(): JsonResponseInterface;
}
