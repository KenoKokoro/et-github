<?php

namespace ET\API\V1\Service\Github\Exceptions;

use App\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class InvalidSearchParameterException extends HttpResponseException
{
    public function __construct()
    {
        $reason = 'Incorrect field provided. Please provide valid owner and repository match';
        parent::__construct(
            $reason,
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            [
                'message' => $reason,
                'validator' => [
                    'owner' => ['Does not match with repository'],
                    'repository' => ['Does not match with owner.'],
                ],
            ]
        );
    }
}
