<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Transactions;

/**
 * Class CommitTransaction.
 *
 * Expression that commits a transaction.
 *
 * @license Apache-2.0
 * @package MisterIcy\QueryBuilder\Transactions
 * @since 1.0
 */
final class CommitTransaction extends TransactionExpression
{
    /**
     * Creates a new Commit Transaction Expression.
     *
     * @param string|null $transactionId An optional transaction ID.
     */
    public function __construct(?string $transactionId)
    {
        parent::__construct(-100);
        $this->transactionId = $transactionId;
        $this->operation = 'COMMIT';
    }
}
