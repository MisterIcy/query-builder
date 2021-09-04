<?php

namespace QueryBuilder\Tests;

use MisterIcy\QueryBuilder\Exceptions\IndexDirectiveAlreadyExistsException;
use MisterIcy\QueryBuilder\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testSimpleQuery(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('test');

        $query = $queryBuilder->getQuery();
        $this->assertEquals('SELECT * FROM `test` `t`;', $query);
    }
    public function testQueryWithUseIndex(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->useIndex(['PRIMARY']);

        $query = $queryBuilder->getQuery();
        $this->assertEquals('SELECT * FROM `test` `t` USE INDEX (PRIMARY);', $query);
    }
    public function testQueryWithUseTwoIndexes(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->useIndex(['PRIMARY', 'idx1']);

        $query = $queryBuilder->getQuery();
        $this->assertEquals('SELECT * FROM `test` `t` USE INDEX (PRIMARY,idx1);', $query);
    }
    public function testQueryWithForceIndex(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->forceIndex(['PRIMARY']);

        $query = $queryBuilder->getQuery();
        $this->assertEquals('SELECT * FROM `test` `t` FORCE INDEX (PRIMARY);', $query);
    }
    public function testQueryWithIgnoreIndex(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->ignoreIndex(['PRIMARY']);

        $query = $queryBuilder->getQuery();
        $this->assertEquals('SELECT * FROM `test` `t` IGNORE INDEX (PRIMARY);', $query);
    }
    public function testQueryWithIndexConflict(): void
    {
        $this->expectException(IndexDirectiveAlreadyExistsException::class);
        $queryBuilder = new QueryBuilder();
        $queryBuilder->select()
            ->from('test')
            ->forceIndex(['PRIMARY'])
            ->ignoreIndex(['PRIMARY']);
    }
}
