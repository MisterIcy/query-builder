<?php

namespace QueryBuilder\Tests;

use MisterIcy\QueryBuilder\Exceptions\IndexDirectiveAlreadyExistsException;
use MisterIcy\QueryBuilder\Exceptions\QueryBuilder\ConflictingOperationsException;
use MisterIcy\QueryBuilder\Exceptions\QueryBuilder\DuplicateOperationException;
use MisterIcy\QueryBuilder\Exceptions\QueryBuilder\JoinWithoutFromException;
use MisterIcy\QueryBuilder\Expressions\Join\InnerJoin;
use MisterIcy\QueryBuilder\Expressions\Join\JoinExpression;
use MisterIcy\QueryBuilder\Operations\Eq;
use MisterIcy\QueryBuilder\Operations\Gte;
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
            ->where(new Eq(1, 1));

        $this->assertEquals('SELECT * FROM `test` `t` WHERE 1 = 1;', $qb->getQuery());
    }

    public function testQueryBuilderAndWhere(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->where(new Eq(1, 1))
            ->andWhere(new Neq(1, 2));

        $this->assertEquals('SELECT * FROM `test` `t` WHERE 1 = 1 AND 1 != 2;', $qb->getQuery());
    }

    public function testQueryBuilderOrWhere(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->where(new Eq(1, 1))
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

    public function testGroupByField(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->groupBy(['id']);

        $this->assertEquals('SELECT * FROM `test` `t` GROUP BY id;', $qb->getQuery());
    }

    public function testInnerJoin(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test', 't1')
            ->innerJoin('test2', new Eq('t1.id', 't2.id'), 't2')
            ->innerJoin('test3', new Eq('t2.id', 't3.id'), 't3');

        $this->assertEquals(
            'SELECT * FROM `test` `t1` INNER JOIN `test2` `t2` ON t1.id = t2.id INNER JOIN `test3` `t3` ON t2.id = t3.id;',
            $qb->getQuery()
        );
    }

    public function testLeftJoin(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test', 't1')
            ->leftJoin('test2', new Eq('t1.id', 't2.id'), false, 't2');

        $this->assertEquals(
            'SELECT * FROM `test` `t1` LEFT JOIN `test2` `t2` ON t1.id = t2.id;',
            $qb->getQuery()
        );
    }

    public function testLeftOuterJoin(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test', 't1')
            ->leftJoin('test2', new Eq('t1.id', 't2.id'), true, 't2');

        $this->assertEquals(
            'SELECT * FROM `test` `t1` LEFT OUTER JOIN `test2` `t2` ON t1.id = t2.id;',
            $qb->getQuery()
        );
    }

    public function testRightJoin(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test', 't1')
            ->rightJoin('test2', new Eq('t1.id', 't2.id'), false, 't2');

        $this->assertEquals(
            'SELECT * FROM `test` `t1` RIGHT JOIN `test2` `t2` ON t1.id = t2.id;',
            $qb->getQuery()
        );
    }

    public function testRightOuterJoin(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test', 't1')
            ->rightJoin('test2', new Eq('t1.id', 't2.id'), true, 't2');

        $this->assertEquals(
            'SELECT * FROM `test` `t1` RIGHT OUTER JOIN `test2` `t2` ON t1.id = t2.id;',
            $qb->getQuery()
        );
    }

    public function testNestedJoin(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->nestedJoin(
                'test2',
                new Eq('t.id', 't2.id'),
                [
                    new InnerJoin('test3', new Eq('t2.id', 't3.id'), 't3')
                ],
                't2'
            );
        $this->assertEquals(
            'SELECT * FROM `test` `t` JOIN (`test2` `t2` INNER JOIN `test3` `t3`) ON (t.id = t2.id AND t2.id = t3.id);',
            $qb->getQuery()
        );
    }

    public function testNestedOuterJoin(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->nestedJoin(
                'test2',
                new Eq('t.id', 't2.id'),
                [
                    new InnerJoin('test3', new Eq('t2.id', 't3.id'), 't3')
                ],
                't2',
                JoinExpression::LEFT_JOIN,
                true
            );
        $this->assertEquals(
            'SELECT * FROM `test` `t` LEFT OUTER JOIN (`test2` `t2` INNER JOIN `test3` `t3`) ON (t.id = t2.id AND t2.id = t3.id);',
            $qb->getQuery()
        );
    }

    public function testSimpleJoin(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test', 't1')
            ->join('test2', new Eq('t1.id', 't2.id'), 't2');

        $this->assertEquals(
            'SELECT * FROM `test` `t1` JOIN `test2` `t2` ON t1.id = t2.id;',
            $qb->getQuery()
        );
    }

    public function testSimpleHaving(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test', 't1')
            ->having(new Gte('COUNT(t1.id)', 1));

        $this->assertEquals(
            'SELECT * FROM `test` `t1` HAVING COUNT(t1.id) >= 1;',
            $qb->getQuery()
        );
    }

    public function testLimitAndOffset(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->limit(10, 0);

        $this->assertEquals('SELECT * FROM `test` `t` LIMIT 0, 10;', $qb->getQuery());
    }

    public function testOrderBy(): void
    {
        $qb = new QueryBuilder();
        $qb->select()
            ->from('test')
            ->limit(10, 0)
            ->orderBy(['id' => 'ASC']);

        $this->assertEquals('SELECT * FROM `test` `t` ORDER BY id ASC LIMIT 0, 10;', $qb->getQuery());
    }

    public function testDoubleSelect(): void
    {
        $this->expectException(DuplicateOperationException::class);
        $qb = new QueryBuilder();
        $qb->select()
            ->select(['id']);
    }

    public function testJoinWithoutFrom(): void
    {
        $this->expectException(JoinWithoutFromException::class);
        $qb = new QueryBuilder();
        $qb->select()
            ->join('test', new Eq(1, 1), 't');
    }

    public function testConflictingOperation(): void
    {
        $this->expectException(ConflictingOperationsException::class);
        $qb = new QueryBuilder();
        $qb->insertInto('test', ['id'])->select();
    }

    public function testInsertInto(): void
    {
        $qb = new QueryBuilder();
        $qb->insertInto('test', ['id']);
        $this->assertEquals('INSERT INTO `test` (id) VALUES (:id);', $qb->getQuery());
    }
}
