<?php

declare(strict_types=1);

namespace QueryBuilder\Tests\Transactions;

use MisterIcy\QueryBuilder\Transactions\CommitTransaction;
use PHPUnit\Framework\TestCase;

final class CommitTransactionTest extends TestCase
{
    public function testCommit(): void
    {
        $commit = new CommitTransaction();
        $this->assertEquals('COMMIT;', strval($commit));
    }
    public function testCommitTransactionWithId(): void
    {
        $id = uniqid();
        $commit = new CommitTransaction($id);
        $this->assertEquals("COMMIT $id;", strval($commit));
    }
}
