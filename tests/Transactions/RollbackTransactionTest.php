<?php

namespace QueryBuilder\Tests\Transactions;

use MisterIcy\QueryBuilder\Transactions\RollbackTransaction;
use PHPUnit\Framework\TestCase;

final class RollbackTransactionTest extends TestCase
{
    public function testRollback(): void
    {
        $rollback = new RollbackTransaction();
        $this->assertEquals('ROLLBACK;', strval($rollback));
    }

    public function testRollbackTransactionWithId(): void
    {
        $id = uniqid();
        $transaction = new RollbackTransaction($id);
        $this->assertEquals("ROLLBACK $id;", strval($transaction));
    }
}
