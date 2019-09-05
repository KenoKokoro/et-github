<?php

namespace ET\API\V1\Http\Response;

use App\Http\Response\JsonResponseInterface;
use Illuminate\Http\JsonResponse;

class JsonResponseFactory implements JsonResponseInterface
{
    const RESULT_GROUP = 'result';

    public function build(int $status, array $append = []): JsonResponse
    {
        switch ($status) {
            case JsonResponse::HTTP_UNPROCESSABLE_ENTITY:
                return $this->unprocessableEntity($append);
                break;
            case JsonResponse::HTTP_UNAUTHORIZED:
                return $this->unauthorized($append);
                break;
        }

        return $this->internalError($append);
    }

    public function ok(array $append = []): JsonResponse
    {
        return $this->instance('Ok.', $append, JsonResponse::HTTP_OK);
    }

    public function created(array $append = []): JsonResponse
    {
        return $this->instance('Created.', $append, JsonResponse::HTTP_CREATED);
    }

    public function badRequest(array $append = []): JsonResponse
    {
        return $this->instance('Bad Request.', $append, JsonResponse::HTTP_FORBIDDEN);
    }

    public function unauthorized(array $append = []): JsonResponse
    {
        return $this->instance('Unauthorized.', $append, JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function forbidden(array $append = []): JsonResponse
    {
        return $this->instance('Forbidden.', $append, JsonResponse::HTTP_FORBIDDEN);
    }

    public function notFound(array $append = []): JsonResponse
    {
        return $this->instance('Not found.', $append, JsonResponse::HTTP_NOT_FOUND);
    }

    public function notAllowed(array $append = []): JsonResponse
    {
        return $this->instance('Method not allowed.', $append, JsonResponse::HTTP_METHOD_NOT_ALLOWED);
    }

    public function unprocessableEntity(array $append = []): JsonResponse
    {
        return $this->instance('Unprocessable Entity', $append, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function internalError(array $append = []): JsonResponse
    {
        return $this->instance('Internal error.', $append, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @param array  $data
     * @param int    $code
     * @return JsonResponse
     */
    private function instance(string $message, array $data, int $code): JsonResponse
    {
        $data['message'] = $data['message'] ?? $message;
        $data[self::RESULT_GROUP] = $data[self::RESULT_GROUP] ?? [];

        return new JsonResponse($data, $code);
    }
}
