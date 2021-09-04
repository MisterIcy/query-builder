<?php

namespace MisterIcy\QueryBuilder;

use MisterIcy\QueryBuilder\BuilderTraits\BuilderTrait;
use MisterIcy\QueryBuilder\BuilderTraits\IndexTrait;
use MisterIcy\QueryBuilder\Expressions\AbstractExpression;
use MisterIcy\QueryBuilder\Expressions\From;
use MisterIcy\QueryBuilder\Expressions\FromQuery;
use MisterIcy\QueryBuilder\Expressions\FullJoin;
use MisterIcy\QueryBuilder\Expressions\GroupBy;
use MisterIcy\QueryBuilder\Expressions\InnerJoin;
use MisterIcy\QueryBuilder\Expressions\JoinExpression;
use MisterIcy\QueryBuilder\Expressions\LeftJoin;
use MisterIcy\QueryBuilder\Expressions\RightJoin;
use MisterIcy\QueryBuilder\Expressions\Select;
use MisterIcy\QueryBuilder\Expressions\Where;
use MisterIcy\QueryBuilder\Operations\AbstractOperation;
use MisterIcy\QueryBuilder\Transactions\CommitTransaction;
use MisterIcy\QueryBuilder\Transactions\RollbackTransaction;
use MisterIcy\QueryBuilder\Transactions\StartTransaction;
use SqlFormatter;

class QueryBuilder
{
    use BuilderTrait;
    use IndexTrait;

    protected bool $isNested = false;

    public function __construct()
    {
        $this->expressions = [];
    }

    public function startTransaction(?string $transactionId = null): self
    {
        return $this->addExpression(new StartTransaction($transactionId));
    }

    public function commit(?string $transactionId = null): self
    {
        return $this->addExpression(new CommitTransaction($transactionId));
    }

    public function rollback(?string $transactionId = null): self
    {
        return $this->addExpression(new RollbackTransaction($transactionId));
    }

    /**
     * @param array<string, string>|null $fields
     * @return self
     */
    public function select(?array $fields = null): self
    {
        return $this->addExpression(new Select($fields));
    }

    public function from(string $table, string $alias = 't'): self
    {
        return $this->addExpression(new From($table, $alias));
    }

    public function fromQuery(QueryBuilder $builder, string $alias = 't'): self
    {
        return $this->addExpression(new FromQuery($builder, $alias));
    }

    public function where(AbstractExpression $expression): self
    {
        return $this->addExpression(new Where($expression));
    }

    public function andWhere(AbstractExpression $expression): self
    {
        return $this->addExpression(new Where($expression, true));
    }

    public function orWhere(AbstractExpression $expression): self
    {
        return $this->addExpression(new Where($expression, false, true));
    }

    public function innerJoin(string $table, AbstractOperation $joinOn, string $alias = 't'): self
    {
        return $this->addExpression(new InnerJoin($table, $joinOn, $alias));
    }

    public function leftJoin(string $table, AbstractOperation $joinOn, bool $outer = false, string $alias = 't'): self
    {
        return $this->addExpression(new LeftJoin($table, $joinOn, $outer, $alias));
    }

    public function rightJoin(string $table, AbstractOperation $joinOn, bool $outer = false, string $alias = 't'): self
    {
        return $this->addExpression(new RightJoin($table, $joinOn, $outer, $alias));
    }

    /**
     * @param string[] $fields
     * @return self
     * @throws Exceptions\InvalidArgumentException
     */
    public function groupBy(array $fields): self
    {
        return $this->addExpression(new GroupBy($fields));
    }

    public function getQuery(bool $format = false): string
    {
        // Sort expressions by priority
        $sortedExpressions = $this->expressions;
        uasort($sortedExpressions, function (AbstractExpression $a, AbstractExpression $b) {
            if ($a->getPriority() === $b->getPriority()) {
                return 0;
            }
            return ($a->getPriority() < $b->getPriority()) ? -1 : 1;
        });

        $builder = '';
        foreach ($this->expressions as $expression) {
            $builder .= $expression . ' ';
        }
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
     */
    public function setIsNested(bool $isNested): self
    {
        $this->isNested = $isNested;
        return $this;
    }
}
