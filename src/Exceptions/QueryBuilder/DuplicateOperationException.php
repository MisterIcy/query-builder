<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Exceptions\QueryBuilder;

use MisterIcy\QueryBuilder\Exceptions\QueryBuilderException;

/**
 * Class DuplicateOperationException.
 *
 * @license Apache-2.0
 * @since 0.2.0
 * @package MisterIcy\QueryBuilder\Exceptions\QueryBuilder
 */
final class DuplicateOperationException extends QueryBuilderException
{
    /**
     * Creates a Duplicate Operations Exception.
     * @param string $currentOperation The operation the user tried to perform
     */
    public function __construct(string $currentOperation)
    {
        parent::__construct(
            sprintf(
                'A(n) %s operation is currently pending on this QueryBuilder.',
                $currentOperation,
            )
        );
    }
}
