<?php

namespace MisterIcy\QueryBuilder\Exceptions;

use Throwable;

final class InvalidArgumentException extends ExpressionException
{
    public function __construct()
    {
        parent::__construct('An invalid argument was passed');
    }
}