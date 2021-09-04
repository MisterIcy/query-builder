<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Operations\AndX;
use MisterIcy\QueryBuilder\Operations\Eq;
use MisterIcy\QueryBuilder\Operations\Neq;
use PHPUnit\Framework\TestCase;

final class AndXTest extends TestCase
{
    public function testSimpleAnd(): void
    {
        $eq = new Eq(1, 1);
        $neq = new Neq(1, 2);
        $and = new AndX([$eq, $neq]);
        $this->assertEquals('1 = 1 AND 1 != 2', strval($and));
    }
    public function testSimpleAndWithoutOps(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new AndX([]);
    }
}
