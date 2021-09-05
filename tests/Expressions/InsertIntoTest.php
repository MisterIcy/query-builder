<?php

namespace QueryBuilder\Tests\Expressions;

use MisterIcy\QueryBuilder\Expressions\InsertInto;
use PHPUnit\Framework\TestCase;

final class InsertIntoTest extends TestCase
{
    public function testSimpleInsertInto(): void
    {
        $insert = new InsertInto('test', ['id', 'username']);
        $this->assertEquals('INSERT INTO `test` (id, username) VALUES (:id, :username)', strval($insert));
    }

    public function testInsertWithValues(): void
    {
        $insert = new InsertInto('test', ['id' => 1, 'username' => 'test']);
        $this->assertEquals('INSERT INTO `test` (id, username) VALUES (1, test)', strval($insert));
    }

    public function testInsertIgnore(): void
    {
        $insert = new InsertInto('test', ['id' => 1, 'username' => 'test']);
        $insert->setHints(['IGNORE']);
        $this->assertEquals('INSERT IGNORE INTO `test` (id, username) VALUES (1, test)', strval($insert));
    }
}
