<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Exceptions\QueryBuilder;

use MisterIcy\QueryBuilder\Exceptions\QueryBuilderException;

/**
 * Class ConflictingOperationsException.
 *
 * @license Apache-2.0
 * @since 0.2.0
 * @package MisterIcy\QueryBuilder\Exceptions\QueryBuilder
 */
final class ConflictingOperationsException extends QueryBuilderException
{
    /**
     * Creates a Conflicting Operations Exception.
     * @param string $currentOperation The operation the user tried to perform
     * @param string $existingOperation The current operation
     */
    public function __construct(string $currentOperation, string $existingOperation)
    {
        parent::__construct(
            sprintf(
                'You have tried to initiate a(n) %s while the QueryBuilder is set up for a(n) %s',
                $currentOperation,
                $existingOperation
            )
        );
    }
}
