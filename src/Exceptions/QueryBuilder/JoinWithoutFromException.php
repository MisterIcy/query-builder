<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Exceptions\QueryBuilder;

use MisterIcy\QueryBuilder\Exceptions\QueryBuilderException;

/**
 *
 */
final class JoinWithoutFromException extends QueryBuilderException
{
    public function __construct($message = 'You attempted to perform a JOIN without specifying FROM')
    {
        parent::__construct($message);
    }
}