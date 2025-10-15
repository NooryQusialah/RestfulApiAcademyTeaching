<?php

namespace App\Exceptions;

use Exception;

class BaseAppException extends Exception
{
    public function __construct(
        string $message = 'Application error',
        protected int $statusCode = 500
    ) {
        parent::__construct($message);
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}

