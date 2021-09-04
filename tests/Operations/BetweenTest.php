<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Operations\Between;
use PHPUnit\Framework\TestCase;

final class BetweenTest extends TestCase
{
    public function testSimpleBetween(): void
    {
        $between = new Between('test', 1, 2);
        $this->assertEquals('test BETWEEN 1 AND 2', strval($between));
    }
}