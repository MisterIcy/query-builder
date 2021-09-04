<?php

namespace MisterIcy\QueryBuilder\Exceptions;

use Throwable;

final class InvalidArgumentException extends ExpressionException
{
    public function __construct(string $message = 'An invalid argument was passed')
    {
        parent::__construct($message);
    }
}
