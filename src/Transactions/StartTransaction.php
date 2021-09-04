<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Transactions;

/**
 * Class StartTransaction.
 *
 * Expression that begins a transaction
 *
 * @license Apache-2.0
 * @package MisterIcy\QueryBuilder\Transactions
 * @since 1.0
 */
final class StartTransaction extends TransactionExpression
{
    /**
     * Creates a new Start Transaction Expression
     *
     * @param string|null $transactionId An optional transaction ID.
     */
    public function __construct(?string $transactionId = null)
    {
        parent::__construct(200);
        $this->operation = 'START TRANSACTION';
        $this->transactionId = $transactionId;
    }
}
