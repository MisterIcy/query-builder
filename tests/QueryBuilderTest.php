<?php

namespace QueryBuilder\Tests;

use MisterIcy\QueryBuilder\Exceptions\IndexDirectiveAlreadyExistsException;
use MisterIcy\QueryBuilder\Operations\Eq;
use MisterIcy\QueryBuilder\Operations\Neq;
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
    public function testQueryBuilderTransaction(): void
    {
        $qb = new QueryBuilder();
        $qb->startTransaction()
            ->commit();

        $this->assertEquals('START TRANSACTION; COMMIT;', $qb->getQuery());
    }

    public function testQueryBuilderRollback(): void
    {
        $qb = new QueryBuilder();
        $qb->startTransaction()
            ->rollback();

        $this->assertEquals('START TRANSACTION; ROLLBACK;', $qb->getQuery());
    }
    public function testQueryBuilderWhere(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->where(new Eq(1,1));

        $this->assertEquals('SELECT * FROM `test` `t` WHERE 1 = 1;', $qb->getQuery());
    }
    public function testQueryBuilderAndWhere(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->where(new Eq(1,1))
            ->andWhere(new Neq(1, 2));

        $this->assertEquals('SELECT * FROM `test` `t` WHERE 1 = 1 AND 1 != 2;', $qb->getQuery());
    }
    public function testQueryBuilderOrWhere(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->where(new Eq(1,1))
            ->orWhere(new Neq(1, 2));

        $this->assertEquals('SELECT * FROM `test` `t` WHERE 1 = 1 OR 1 != 2;', $qb->getQuery());
    }
    public function testNestedSelectFrom(): void
    {
        $qb1 = new QueryBuilder();
        $qb1->select()
            ->from('test1');
        $qb2 = new QueryBuilder();
        $qb2->select()
            ->fromQuery($qb1, 'c');

        $this->assertEquals('SELECT * FROM (SELECT * FROM `test1` `t`) `c`;', $qb2->getQuery());
    }

    public function testSelectFields(): void
    {
        $qb = new QueryBuilder();
        $qb->select(['id' => 'testId'])
            ->from('test', 't');

        $this->assertEquals('SELECT `id` `testId` FROM `test` `t`;', $qb->getQuery());
    }
}
