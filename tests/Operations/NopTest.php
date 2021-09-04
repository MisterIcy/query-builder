<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Operations\Nop;
use PHPUnit\Framework\TestCase;

class NopTest extends TestCase
{
    public function testNoOperation(): void
    {
        $this->assertEquals('', strval(new Nop()));
    }

}