<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Expressions\GroupBy;
use PHPUnit\Framework\TestCase;

final class GroupByTest extends TestCase
{
    public function testSimpleGroupBy(): void
    {
        $this->assertEquals('GROUP BY id', new GroupBy(['id']));
    }
    public function testGroupByWithNoArguments(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new GroupBy([]);
    }

}