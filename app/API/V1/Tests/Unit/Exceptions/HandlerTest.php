<?php

namespace ET\API\V1\Tests\Unit\Exceptions;

use App\Exceptions\HttpResponseException;
use App\Http\Response\JsonResponseInterface;
use ET\API\V1\Exceptions\Handler;
use ET\API\V1\Tests\Unit\UnitTestCase;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery as m;
use Mockery\MockInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class HandlerTest extends UnitTestCase
{
    /**
     * @var MockInterface|JsonResponseInterface
     */
    private $jsonFactory;

    /**
     * @var MockInterface|JsonResponse
     */
    private $jsonResponse;

    /**
     * @var MockInterface|Request
     */
    private $request;

    /**
     * @var Handler
     */
    private $fixture;

    protected function setUp(): void
    {
        $this->jsonFactory = m::mock(JsonResponseInterface::class);
        $this->jsonResponse = m::mock(JsonResponse::class);
        $this->request = m::mock(Request::class);
        $this->fixture = new Handler($this->jsonFactory);
    }

    /** @test */
    public function should_return_bad_request_when_accept_header_is_not_application_json(): void
    {
        $exception = m::mock(Exception::class);
        $this->request
            ->shouldReceive('expectsJson')
            ->once()
            ->andReturn(false);
        $this->jsonFactory
            ->shouldReceive('badRequest')
            ->once()
            ->with(['message' => 'Expected Accept header with application/json value'])
            ->andReturn($this->jsonResponse);

        $actual = $this->fixture->render($this->request, $exception);

        self::assertInstanceOf(JsonResponse::class, $actual);
    }

    /** @test */
    public function should_build_response_if_exception_is_http_response_exception(): void
    {
        $this->request
            ->shouldReceive('expectsJson')
            ->once()
            ->andReturn(true);
        $exception = m::mock(HttpResponseException::class);
        $exception
            ->shouldReceive('getStatus')
            ->once()
            ->andReturn(400);
        $exception
            ->shouldReceive('getData')
            ->once()
            ->andReturn(['json' => 'message']);
        $this->jsonFactory
            ->shouldReceive('build')
            ->once()
            ->with(400, ['json' => 'message'])
            ->andReturn($this->jsonResponse);

        $actual = $this->fixture->render($this->request, $exception);

        self::assertInstanceOf(JsonResponse::class, $actual);
    }

    /** @test */
    public function should_return_validation_exception_response(): void
    {
        $this->request
            ->shouldReceive('expectsJson')
            ->once()
            ->andReturn(true);
        $exception = m::mock(ValidationException::class);
        $validator = m::mock(Validator::class);
        $validator
            ->shouldReceive('getMessageBag')
            ->once()
            ->andReturn(['field' => ['message 1', 'message 2']]);
        $exception->validator = $validator;
        $this->jsonFactory
            ->shouldReceive('unprocessableEntity')
            ->once()
            ->with(['validator' => ['field' => ['message 1', 'message 2']]])
            ->andReturn($this->jsonResponse);

        $actual = $this->fixture->render($this->request, $exception);

        self::assertInstanceOf(JsonResponse::class, $actual);
    }

    /** @test
     * @param MockInterface|ModelNotFoundException|NotFoundHttpException $exception
     * @dataProvider notFoundExceptions
     */
    public function should_return_not_found_response(MockInterface $exception): void
    {
        $this->request
            ->shouldReceive('expectsJson')
            ->once()
            ->andReturn(true);
        $this->jsonFactory
            ->shouldReceive('notFound')
            ->once()
            ->andReturn($this->jsonResponse);

        $actual = $this->fixture->render($this->request, $exception);

        self::assertInstanceOf(JsonResponse::class, $actual);
    }

    /**
     * @test
     * @dataProvider forbiddenExceptions
     * @param MockInterface|AuthorizationException|UnauthorizedHttpException $exception
     */
    public function should_return_forbidden_response(MockInterface $exception): void
    {
        $this->request
            ->shouldReceive('expectsJson')
            ->once()
            ->andReturn(true);
        $this->jsonFactory
            ->shouldReceive('forbidden')
            ->once()
            ->andReturn($this->jsonResponse);

        $actual = $this->fixture->render($this->request, $exception);

        self::assertInstanceOf(JsonResponse::class, $actual);
    }

    /** @test */
    public function should_return_unauthorized_response(): void
    {
        $this->request
            ->shouldReceive('expectsJson')
            ->once()
            ->andReturn(true);
        $exception = m::mock(AuthenticationException::class);
        $this->jsonFactory
            ->shouldReceive('unauthorized')
            ->once()
            ->andReturn($this->jsonResponse);

        $actual = $this->fixture->render($this->request, $exception);

        self::assertInstanceOf(JsonResponse::class, $actual);
    }

    /** @test */
    public function should_return_method_not_allowed_response(): void
    {
        $this->request
            ->shouldReceive('expectsJson')
            ->once()
            ->andReturn(true);
        $exception = m::mock(MethodNotAllowedHttpException::class);
        $this->jsonFactory
            ->shouldReceive('notAllowed')
            ->once()
            ->andReturn($this->jsonResponse);

        $actual = $this->fixture->render($this->request, $exception);

        self::assertInstanceOf(JsonResponse::class, $actual);
    }

    /** @test */
    public function should_return_internal_error_response(): void
    {
        $this->request
            ->shouldReceive('expectsJson')
            ->once()
            ->andReturn(true);
        $exception = m::mock(Exception::class);
        $this->jsonFactory
            ->shouldReceive('internalError')
            ->once()
            ->andReturn($this->jsonResponse);

        $actual = $this->fixture->render($this->request, $exception);

        self::assertInstanceOf(JsonResponse::class, $actual);
    }

    /**
     * @return array
     */
    public function forbiddenExceptions(): array
    {
        return [
            [
                m::mock(AuthorizationException::class),
            ],
            [
                m::mock(UnauthorizedHttpException::class),
            ],
        ];
    }

    /**
     * @return array
     */
    public function notFoundExceptions(): array
    {
        return [
            [
                m::mock(ModelNotFoundException::class),
            ],
            [
                m::mock(NotFoundHttpException::class),
            ],
        ];
    }
}
