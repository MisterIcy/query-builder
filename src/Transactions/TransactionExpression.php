<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Transactions;

use MisterIcy\QueryBuilder\Expressions\AbstractExpression;

/**
 * Class TransactionExpression.
 *
 * Defines a Transaction Expression.
 *
 * @license Apache-2.0
 * @package MisterIcy\QueryBuilder\Transactions
 * @since 1.0
 */
abstract class TransactionExpression extends AbstractExpression
{
    /**
     * An optional transaction ID
     * @var string|null
     */
    protected ?string $transactionId = null;

    /**
     * The command to be executed
     * @var string
     */
    protected string $operation;

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->operation . (!is_null($this->transactionId) ? ' ' . $this->transactionId : '') . ';';
    }
}
