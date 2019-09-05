<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class HttpResponseException extends Exception
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var array
     */
    private $data = [];

    public function __construct(string $message, int $status = 400, array $data = [], Throwable $previous = null)
    {
        $this->status = $status;
        $this->data = $data;
        parent::__construct($message, 0, $previous);
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
