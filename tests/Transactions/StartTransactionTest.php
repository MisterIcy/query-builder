<?php

namespace QueryBuilder\Tests\Transactions;

use MisterIcy\QueryBuilder\Transactions\StartTransaction;
use PHPUnit\Framework\TestCase;

final class StartTransactionTest extends TestCase
{
    public function testStartTransaction(): void
    {
        $transaction = new StartTransaction();
        $this->assertEquals('START TRANSACTION;', strval($transaction));
    }

    public function testStartTransactionWithId(): void
    {
        $id = uniqid();
        $transaction = new StartTransaction($id);
        $this->assertEquals("START TRANSACTION $id;", strval($transaction));
    }
}
