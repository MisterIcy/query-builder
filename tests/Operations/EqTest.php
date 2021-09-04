<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;
use MisterIcy\QueryBuilder\Operations\Eq;
use PHPUnit\Framework\TestCase;

final class EqTest extends TestCase
{
    public function testSimpleEquality(): void
    {
        $eq = new Eq(1, 2);
        $this->assertEquals('1 = 2', strval($eq));
    }
    public function testEqualityWithOneParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Eq(1, null);
    }
    public function testEqualityWithNoParameters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Eq(null, null);
    }
    public function testEqualityWithArrayOrObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Eq([1], [2]);
    }
}
