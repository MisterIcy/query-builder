<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;
use MisterIcy\QueryBuilder\Operations\In;
use PHPUnit\Framework\TestCase;

final class InTest extends TestCase
{
    public function testSimpleInValue(): void
    {
        $in = new In('test', ['alpha', 'beta']);
        $this->assertEquals('test IN (alpha,beta)', strval($in));
    }
    public function testInWithNoFields(): void
    {
        $this->expectException(NullArgumentException::class);
        new In('test', []);
    }
}