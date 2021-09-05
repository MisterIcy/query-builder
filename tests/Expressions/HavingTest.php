<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Expressions\Having;
use MisterIcy\QueryBuilder\Operations\Gte;
use PHPUnit\Framework\TestCase;

final class HavingTest extends TestCase
{
    public function testSimpleHaving(): void
    {
        $having = new Having(new Gte('t1', 2));
        $this->assertEquals('HAVING t1 >= 2', strval($having));
    }
}
