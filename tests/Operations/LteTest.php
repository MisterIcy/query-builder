<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;
use MisterIcy\QueryBuilder\Operations\Lte;
use PHPUnit\Framework\TestCase;

final class LteTest extends TestCase
{
    public function testSimpleLessThanOrEqual(): void
    {
        $eq = new Lte(1, 2);
        $this->assertEquals('1 <= 2', strval($eq));
    }
    public function testLessThanOrEqualWithOneParameter(): void
    {
        $this->expectException(NullArgumentException::class);
        new Lte(1, null);
    }
    public function testLessThanOrEqualWithNoParameters(): void
    {
        $this->expectException(NullArgumentException::class);
        new Lte(null, null);
    }
    public function testLessThanOrEqualWithArrayOrObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Lte([1], [2]);
    }
}