<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Expressions\Select;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    public function testSimpleSelect(): void
    {
        $select = new Select();
        $this->assertEquals('SELECT *', strval($select));
    }
    public function testSelectWithNamedField(): void
    {
        $select = new Select(['id' => 'testId']);
        $this->assertEquals('SELECT `id` `testId` ', strval($select));
    }
    public function testSelectWithUnnamedField(): void
    {
        $select = new Select(['id']);
        $this->assertEquals('SELECT `id` `id` ', strval($select));
    }
    public function testSelectWithStraightJoin(): void
    {
        $select = new Select(['id']);
        $select->setStraightJoin(true);
        $this->assertEquals('SELECT STRAIGHT_JOIN `id` `id` ', strval($select));
    }
}
