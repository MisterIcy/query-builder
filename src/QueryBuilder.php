<?php

namespace MisterIcy\QueryBuilder;

use MisterIcy\QueryBuilder\BuilderTraits\BuilderTrait;
use MisterIcy\QueryBuilder\BuilderTraits\IndexTrait;
use MisterIcy\QueryBuilder\Expressions\AbstractExpression;
use MisterIcy\QueryBuilder\Expressions\From;
use MisterIcy\QueryBuilder\Expressions\FromQuery;
use MisterIcy\QueryBuilder\Expressions\GroupBy;
use MisterIcy\QueryBuilder\Expressions\Join\InnerJoin;
use MisterIcy\QueryBuilder\Expressions\Join\JoinExpression;
use MisterIcy\QueryBuilder\Expressions\Join\LeftJoin;
use MisterIcy\QueryBuilder\Expressions\Join\NestedJoin;
use MisterIcy\QueryBuilder\Expressions\Join\RightJoin;
use MisterIcy\QueryBuilder\Expressions\Select;
use MisterIcy\QueryBuilder\Expressions\Where;
use MisterIcy\QueryBuilder\Operations\AbstractOperation;
use MisterIcy\QueryBuilder\Transactions\CommitTransaction;
use MisterIcy\QueryBuilder\Transactions\RollbackTransaction;
use MisterIcy\QueryBuilder\Transactions\StartTransaction;
use SqlFormatter;

/**
 * Class QueryBuilder.
 *
 * @license Apache-2.0
 * @package MisterIcy\QueryBuilder
 * @since 1.0
 */
class QueryBuilder
{
    use BuilderTrait;
    use IndexTrait;

    /**
     * Defines if this query builder is nested inside another query builder.
     *
     * @var bool
     */
    protected bool $isNested = false;

    /**
     * Create a new QueryBuilder
     */
    public function __construct()
    {
        $this->expressions = [];
    }

    /**
     * Begin a new Transaction.
     * Note that this implementation of QueryBuilder does not allow for nested transactions. Nested transactions are
     * only possible in nested QueryBuilders.
     *
     * @param string|null $transactionId A transaction id, optionally, to be able to commit or rollback certain changes.
     * @since 1.0
     * @return self
     */
    public function startTransaction(?string $transactionId = null): self
    {
        return $this->addExpression(new StartTransaction($transactionId));
    }

    /**
     * Commit a transaction.
     *
     * @param string|null $transactionId
     * @since 1.0
     * @return self
     */
    public function commit(?string $transactionId = null): self
    {
        return $this->addExpression(new CommitTransaction($transactionId));
    }

    /**
     * Rollback a transaction.
     *
     * @param string|null $transactionId
     * @since 1.0
     * @return self
     */
    public function rollback(?string $transactionId = null): self
    {
        return $this->addExpression(new RollbackTransaction($transactionId));
    }

    /**
     * Performs a SELECT operation.
     *
     * @param array<string, string>|array<int, string>|null $fields A list of fields, or null to SELECT *.
     *
     * @return self
     */
    public function select(?array $fields = null): self
    {
        return $this->addExpression(new Select($fields));
    }

    /**
     * Adds a FROM clause.
     *
     * @param string $table The table to select data from.
     * @param string $alias The table's alias, defaults to `t`.
     * @return self
     */
    public function from(string $table, string $alias = 't'): self
    {
        return $this->addExpression(new From($table, $alias));
    }

    /**
     * Adds a FROM clause from a sub query.
     *
     * @param QueryBuilder $builder A query builder that contains the sub query
     * @param string $alias The alias of the sub query, defaults to `c`
     * @return self
     */
    public function fromQuery(QueryBuilder $builder, string $alias = 'c'): self
    {
        return $this->addExpression(new FromQuery($builder, $alias));
    }

    /**
     * Adds a WHERE clause.
     *
     * @param AbstractOperation $operation An operation which will be evaluated in WHERE
     * @return self
     */
    public function where(AbstractOperation $operation): self
    {
        return $this->addExpression(new Where($operation));
    }

    /**
     * Adds an AND statement to the WHERE clause
     * @param AbstractOperation $operation
     * @return self
     */
    public function andWhere(AbstractOperation $operation): self
    {
        return $this->addExpression(new Where($operation, true));
    }

    /**
     * Adds an OR statement to the WHERE clause
     * @param AbstractOperation $operation
     * @return self
     */
    public function orWhere(AbstractOperation $operation): self
    {
        return $this->addExpression(new Where($operation, false, true));
    }

    /**
     * Adds a JOIN statement.
     *
     * @param string $table The table to join to.
     * @param AbstractOperation $joinOn An operation that defines the JOIN relationship.
     * @param string $alias The alias of the table, defaults to `t`
     * @return self
     */
    public function join(string $table, AbstractOperation $joinOn, string $alias = 't'): self
    {
        return $this->addExpression(new JoinExpression($table, $joinOn, $alias));
    }

    /**
     * Adds an INNER JOIN statement
     *
     * @param string $table The table to join to.
     * @param AbstractOperation $joinOn An operation that defines the JOIN relationship.
     * @param string $alias The alias of the table, defaults to `t`
     * @return self
     */
    public function innerJoin(string $table, AbstractOperation $joinOn, string $alias = 't'): self
    {
        return $this->addExpression(new InnerJoin($table, $joinOn, $alias));
    }

    /**
     * Adds a LEFT JOIN statement.
     *
     * @param string $table The table to join to.
     * @param AbstractOperation $joinOn An operation that defines the JOIN relationship.
     * @param bool $outer Defines if this is an OUTER join or not, false by default.
     * @param string $alias The alias of the table, defaults to `t`
     * @return self
     */
    public function leftJoin(string $table, AbstractOperation $joinOn, bool $outer = false, string $alias = 't'): self
    {
        return $this->addExpression(new LeftJoin($table, $joinOn, $outer, $alias));
    }

    /**
     * Adds a RIGHT JOIN statement.
     *
     * @param string $table The table to join to.
     * @param AbstractOperation $joinOn An operation that defines the JOIN relationship.
     * @param bool $outer Defines if this is an OUTER join or not, false by default.
     * @param string $alias The alias of the table, defaults to `t`
     * @return self
     */
    public function rightJoin(string $table, AbstractOperation $joinOn, bool $outer = false, string $alias = 't'): self
    {
        return $this->addExpression(new RightJoin($table, $joinOn, $outer, $alias));
    }

    /**
     * Adds a JOIN Expression.
     *
     * @param string $table The first table to Join to
     * @param AbstractOperation $joinOn The relationship between the selected table and the joined table
     * @param array<JoinExpression> $joins An array of {@see JoinExpression}s which define further joins
     * @param string $alias The alias of the first table.
     * @param string $type The join type. Choose one the constants of {@see JoinExpression}.
     * @param bool $outer Defines if this is an OUTER JOIN or not, false by default.
     * @return self
     */
    public function nestedJoin(
        string $table,
        AbstractOperation $joinOn,
        array $joins,
        string $alias = 'c',
        string $type = '',
        bool $outer = false
    ): self {
        return $this->addExpression(new NestedJoin($table, $joinOn, $joins, $alias, $type, $outer));
    }

    /**
     * Adds a GROUP BY Statement
     * @param string[] $fields A list of fields to GROUP BY.
     * @return self
     * @throws Exceptions\InvalidArgumentException Thrown when no elements exist in $fields..
     */
    public function groupBy(array $fields): self
    {
        return $this->addExpression(new GroupBy($fields));
    }

    /**
     * Returns a query.
     *
     * @param bool $format Set to true if you want the query to be properly formatted (line breaks, indentation, etc).
     *
     * @return string The query.
     */
    public function getQuery(bool $format = false): string
    {
        // Sort expressions by priority:
        uasort($this->expressions, [$this, 'sortExpressions']);

        $builder = implode(' ', $this->expressions);
        //@codeCoverageIgnoreStart
        if ($format) {
            $builder = SqlFormatter::format($builder, false);
        }
        //@codeCoverageIgnoreEnd

        $builder = rtrim($builder);
        if (!str_ends_with($builder, ';') && !$this->isNested()) {
            $builder .= ';';
        }
        return $builder;
    }

    /**
     * @return bool
     */
    public function isNested(): bool
    {
        return $this->isNested;
    }

    /**
     * @param bool $isNested
     * @return QueryBuilder
     */
    public function setIsNested(bool $isNested): self
    {
        $this->isNested = $isNested;
        return $this;
    }

    /**
     * Helper function for expression sorting
     *
     * @param AbstractExpression $a
     * @param AbstractExpression $b
     * @return int
     */
    private function sortExpressions(AbstractExpression $a, AbstractExpression $b): int
    {
        if ($a->getPriority() === $b->getPriority()) {
            return 0;
        }
        return ($a->getPriority() < $b->getPriority()) ? 1 : -1;
    }
}
