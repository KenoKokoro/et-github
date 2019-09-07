<?php

namespace ET\API\V1\Service\Github\Exceptions;

use App\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class GithubBadRequest extends HttpResponseException
{
    public function __construct(string $message)
    {
        parent::__construct(
            $message,
            JsonResponse::HTTP_BAD_REQUEST,
            ['message' => $message]
        );
    }
}
