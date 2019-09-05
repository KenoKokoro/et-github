<?php

namespace App\API\V1\Exceptions;

use App\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ApiKeyIsNotSet extends HttpResponseException
{
    public function __construct()
    {
        $reason = 'No authentication is provided.';
        parent::__construct(
            $reason,
            JsonResponse::HTTP_UNAUTHORIZED,
            ['message' => $reason]
        );
    }
}
