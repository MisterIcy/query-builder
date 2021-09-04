<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;
use MisterIcy\QueryBuilder\Operations\Gte;
use PHPUnit\Framework\TestCase;

final class GteTest extends TestCase
{
    public function testSimpleGreaterThanOrEqual(): void
    {
        $eq = new Gte(1, 2);
        $this->assertEquals('1 >= 2', strval($eq));
    }
    public function testGreaterThanOrEqualWithOneParameter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Gte(1, null);
    }
    public function testGreaterThanOrEqualWithNoParameters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Gte(null, null);
    }
    public function testGreaterThanOrEqualWithArrayOrObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Gte([1], [2]);
    }
}
