<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Transactions;

/**
 * Class RollbackTransaction.
 *
 * @license Apache-2.0
 * @package MisterIcy\QueryBuilder\Transactions
 * @since 1.0
 */
final class RollbackTransaction extends TransactionExpression
{
    /**
     * Creates a new Rollback Expression.
     * @param string|null $transactionId An optional transaction ID.
     */
    public function __construct(?string $transactionId)
    {
        parent::__construct(-100);
        $this->transactionId = $transactionId;
        $this->operation = "ROLLBACK";
    }
}
