<?php

namespace QueryBuilder\Tests\Operations;

use MisterIcy\QueryBuilder\Operations\Like;
use PHPUnit\Framework\TestCase;

final class LikeTest extends TestCase
{
    public function testSimpleLikeExp(): void
    {
        $like = new Like('test', '%test%');
        $this->assertEquals('test LIKE %test%', strval($like));
    }

}