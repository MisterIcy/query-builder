<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Operations\IsNull;
use PHPStan\Testing\TestCase;

final class IsNullTest extends TestCase
{
    public function testSimpleIsNull(): void
    {
        $null = new IsNull('test');
        $this->assertEquals('test IS NULL', strval($null));
    }
}
