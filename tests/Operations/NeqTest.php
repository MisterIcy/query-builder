<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;
use MisterIcy\QueryBuilder\Operations\Neq;
use PHPUnit\Framework\TestCase;

final class NeqTest extends TestCase
{
    public function testSimpleInequality(): void
    {
        $eq = new Neq(1, 2);
        $this->assertEquals('1 != 2', strval($eq));
    }
    public function testInequalityWithOneParameter(): void
    {
        $this->expectException(NullArgumentException::class);
        new Neq(1, null);
    }
    public function testInequalityWithNoParameters(): void
    {
        $this->expectException(NullArgumentException::class);
        new Neq(null, null);
    }
    public function testInequalityWithArrayOrObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Neq([1], [2]);
    }
}