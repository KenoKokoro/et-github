<?php

namespace ET\API\V1\Exceptions;

use App\Exceptions\HttpResponseException;
use App\Http\Response\JsonResponseInterface;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * @var JsonResponseInterface
     */
    private $jsonResponse;

    public function __construct(JsonResponseInterface $jsonResponse)
    {
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * A list of the exception types that should not be reported.
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        HttpResponseException::class,
    ];

    /**
     * Render an exception into an HTTP response.
     * @param Request   $request
     * @param Exception $exception
     * @return JsonResponse
     */
    public function render($request, Exception $exception): JsonResponse
    {
        if ($request->expectsJson()) {
            return $this->jsonException($exception);
        }

        return $this->jsonResponse->badRequest(['message' => 'Expected Accept header with application/json value']);
    }

    /**
     * @param Exception $exception
     * @return JsonResponse
     */
    protected function jsonException(Exception $exception): JsonResponse
    {
        if ($exception instanceof HttpResponseException) {
            return $this->jsonResponse->build($exception->getStatus(), $exception->getData());
        } elseif ($exception instanceof ValidationException) {
            /** @var $exception ValidationException */
            return $this->jsonResponse->unprocessableEntity([
                'validator' => $exception->validator->getMessageBag(),
            ]);
        } elseif ($exception instanceof ModelNotFoundException) {
            return $this->jsonResponse->notFound();
        } elseif ($exception instanceof AuthorizationException
                  or $exception instanceof UnauthorizedHttpException) {
            return $this->jsonResponse->forbidden();
        } elseif ($exception instanceof AuthenticationException) {
            return $this->jsonResponse->unauthorized();
        } elseif ($exception instanceof NotFoundHttpException) {
            return $this->jsonResponse->notFound();
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return $this->jsonResponse->notAllowed();
        }

        return $this->jsonResponse->internalError(['message' => $exception->getMessage()]);
    }
}
