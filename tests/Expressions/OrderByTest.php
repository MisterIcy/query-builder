<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Expressions\OrderBy;
use PHPUnit\Framework\TestCase;

class OrderByTest extends TestCase
{
    public function testSimpleOrderBy(): void
    {
        $order = new OrderBy(['id' => 'ASC']);
        $this->assertEquals('ORDER BY id ASC', strval($order));
    }
    public function testOrderByWithManyElements(): void
    {
        $order = new OrderBy(['id' => 'ASC', 'timestamp' => 'DESC']);
        $this->assertEquals('ORDER BY id ASC, timestamp DESC', strval($order));
    }
}
