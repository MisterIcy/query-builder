<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Operations\IsNotNull;
use PHPUnit\Framework\TestCase;

final class IsNotNullTest extends TestCase
{
    public function testSimpleIsNotNull(): void
    {
        $nn = new IsNotNull('test');
        $this->assertEquals('test IS NOT NULL', strval($nn));
    }
}
