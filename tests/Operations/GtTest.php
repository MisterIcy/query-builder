<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;
use MisterIcy\QueryBuilder\Operations\Gt;
use PHPUnit\Framework\TestCase;

final class GtTest extends TestCase
{
    public function testSimpleGreaterThan(): void
    {
        $eq = new Gt(1, 2);
        $this->assertEquals('1 > 2', strval($eq));
    }
    public function testGreaterThanWithOneParameter(): void
    {
        $this->expectException(NullArgumentException::class);
        new Gt(1, null);
    }
    public function testGreaterThanWithNoParameters(): void
    {
        $this->expectException(NullArgumentException::class);
        new Gt(null, null);
    }
    public function testGreaterThanWithArrayOrObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Gt([1], [2]);
    }
}