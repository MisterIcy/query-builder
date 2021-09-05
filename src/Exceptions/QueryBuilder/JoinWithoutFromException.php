<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Exceptions\QueryBuilder;

use MisterIcy\QueryBuilder\Exceptions\QueryBuilderException;

/**
 * Class JoinWithoutFromException.
 *
 * @license Apache-2.0
 * @since 0.2.0
 * @package MisterIcy\QueryBuilder\Exceptions\QueryBuilder
 */
final class JoinWithoutFromException extends QueryBuilderException
{
    public function __construct($message = 'You attempted to perform a JOIN without specifying FROM')
    {
        parent::__construct($message);
    }
}
