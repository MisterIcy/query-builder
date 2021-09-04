<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Expressions\Join\InnerJoin;
use MisterIcy\QueryBuilder\Operations\Eq;
use PHPUnit\Framework\TestCase;

final class InnerJoinTest extends TestCase
{
    public function testSimpleInnerJoin(): void
    {
        $inner = new InnerJoin('temp', new Eq('t.id', 't1.id'));
        $this->assertEquals('INNER JOIN `temp` `t` ON t.id = t1.id', strval($inner));
    }

}