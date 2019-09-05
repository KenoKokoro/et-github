<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

interface JsonResponseInterface
{
    /**
     * Build the response from the status code
     * @param int   $status
     * @param array $append
     * @return JsonResponse
     */
    public function build(int $status, array $append = []): JsonResponse;

    /**
     * Return a 200 response
     * @param array $append
     * @return JsonResponse
     */
    public function ok(array $append = []): JsonResponse;

    /**
     * Return a 201 response
     * @param array $append
     * @return JsonResponse
     */
    public function created(array $append = []): JsonResponse;

    /**
     * Return a 400 response
     * @param array $append
     * @return JsonResponse
     */
    public function badRequest(array $append = []): JsonResponse;

    /**
     * Return 401 response
     * @param array $append
     * @return JsonResponse
     */
    public function unauthorized(array $append = []): JsonResponse;

    /**
     * Return 403 response
     * @param array $append
     * @return JsonResponse
     */
    public function forbidden(array $append = []): JsonResponse;

    /**
     * Return 404 response
     * @param array $append
     * @return JsonResponse
     */
    public function notFound(array $append = []): JsonResponse;

    /**
     * Return 405 response
     * @param array $append
     * @return JsonResponse
     */
    public function notAllowed(array $append = []): JsonResponse;

    /**
     * Return 422 response
     * @param array $append
     * @return JsonResponse
     */
    public function unprocessableEntity(array $append = []): JsonResponse;

    /**
     * Return 500 response
     * @param array $append
     * @return JsonResponse
     */
    public function internalError(array $append = []): JsonResponse;
}
