<?php

namespace MisterIcy\QueryBuilder\Exceptions;

final class NullArgumentException extends ExpressionException
{
    public function __construct()
    {
        parent::__construct('A null argument was passed in a constructor that requires both arguments');
    }
}
