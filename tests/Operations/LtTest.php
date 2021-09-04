<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;
use MisterIcy\QueryBuilder\Operations\Lt;
use PHPUnit\Framework\TestCase;

final class LtTest extends TestCase
{
    public function testSimpleLessThan(): void
    {
        $eq = new Lt(1, 2);
        $this->assertEquals('1 < 2', strval($eq));
    }
    public function testLessThanWithOneParameter(): void
    {
        $this->expectException(NullArgumentException::class);
        new Lt(1, null);
    }
    public function testLessThanWithNoParameters(): void
    {
        $this->expectException(NullArgumentException::class);
        new Lt(null, null);
    }
    public function testLessThanWithArrayOrObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Lt([1], [2]);
    }
}