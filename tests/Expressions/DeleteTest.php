<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Expressions\Delete;
use PHPUnit\Framework\TestCase;

final class DeleteTest extends TestCase
{
    public function testSimpleDelete(): void
    {
        $delete = new Delete('test');
        $this->assertEquals('DELETE FROM `test` `t`', strval($delete));
    }
    public function testDeleteWithAlias(): void
    {
        $delete = new Delete('test', 'a');
        $this->assertEquals('DELETE FROM `test` `a`', strval($delete));
    }
    public function testDeleteWithIgnore(): void
    {
        $delete = new Delete('test');
        $delete->setIgnore(true);
        $this->assertEquals('DELETE IGNORE FROM `test` `t`', strval($delete));
    }


}