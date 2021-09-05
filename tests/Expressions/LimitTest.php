<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Expressions\Limit;
use PHPUnit\Framework\TestCase;

final class LimitTest extends TestCase
{
    public function testSimpleLimit(): void
    {
        $limit = new Limit(10);
        $this->assertEquals('LIMIT 10', strval($limit));
    }

    public function testLimitAndOffset(): void
    {
        $limit = new Limit(10, 20);
        $this->assertEquals('LIMIT 20, 10', strval($limit));
    }
}
