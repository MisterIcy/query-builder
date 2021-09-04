<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Expressions\Where;
use MisterIcy\QueryBuilder\Operations\AndX;
use MisterIcy\QueryBuilder\Operations\Eq;
use MisterIcy\QueryBuilder\Operations\Gt;
use MisterIcy\QueryBuilder\Operations\Lt;
use MisterIcy\QueryBuilder\Operations\Neq;
use MisterIcy\QueryBuilder\Operations\OrX;
use PHPUnit\Framework\TestCase;

final class WhereTest extends TestCase
{
    public function testSimpleWhere(): void
    {
        $where = new Where(new Eq(1, 2));
        $this->assertEquals('WHERE 1 = 2', strval($where));
    }

    public function testWhereWithAndExpression(): void
    {
        $where = new Where(
            new AndX(
                [
                    new Eq(1, 1),
                    new Neq(1, 2)
                ]
            )
        );
        $this->assertEquals('WHERE 1 = 1 AND 1 != 2', strval($where));
    }

    public function testAndWhereWithSimpleExpression(): void
    {
        $where = new Where(new Eq(1, 1), true);
        $this->assertEquals('AND 1 = 1', strval($where));
    }

    public function testAndWhereWithComplexExpression(): void
    {
        $where = new Where(
            new AndX(
                [
                    new Eq(1, 1),
                    new Neq(1, 2)
                ]
            ),
            true
        );
        $this->assertEquals('AND 1 = 1 AND 1 != 2', strval($where));
    }

    public function testOrWhereWithSimpleExpression(): void
    {
        $where = new Where(new Eq(1, 1), false, true);
        $this->assertEquals('OR 1 = 1', strval($where));
    }

    public function testOrWhereWithComplexExpression(): void
    {
        $where = new Where(
            new AndX(
                [
                    new Eq(1, 1),
                    new Neq(1, 2)
                ]
            ),
            false,
            true
        );
        $this->assertEquals('OR 1 = 1 AND 1 != 2', strval($where));
    }

    public function testComplexWhere(): void
    {
        $where = new Where(
            new AndX(
                [
                    new Eq(1, 1),
                    new OrX([new Lt(1, 2), new Gt(1, 2)])
                ]
            )
        );
        $this->assertEquals('WHERE 1 = 1 AND 1 < 2 OR 1 > 2', strval($where));
    }
}
