<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Operations\Eq;
use MisterIcy\QueryBuilder\Operations\Neq;
use MisterIcy\QueryBuilder\Operations\OrX;
use PHPUnit\Framework\TestCase;

final class OrXTest extends TestCase
{
    public function testSimpleOr(): void
    {
        $eq = new Eq(1, 1);
        $neq = new Neq(1, 2);
        $and = new OrX([$eq, $neq]);
        $this->assertEquals('1 = 1 OR 1 != 2', strval($and));
    }
    public function testSimpleOrWithoutOps(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new OrX([]);
    }
}
