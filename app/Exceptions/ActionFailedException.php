<?php

namespace App\Exceptions;

class ActionFailedException extends BaseAppException
{
    public function __construct(string $message = 'Action failed', int $status = 422)
    {
        parent::__construct($message, $status);
    }
}
