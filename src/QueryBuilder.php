<?php

namespace MisterIcy\QueryBuilder;

use MisterIcy\QueryBuilder\Expressions\AbstractExpression;
use MisterIcy\QueryBuilder\Expressions\From;
use MisterIcy\QueryBuilder\Expressions\Select;

class QueryBuilder
{
    /**
     * @var array<AbstractExpression>
     */
    protected array $expressions;

    public function __construct()
    {
        $this->expressions = [];
    }

    public function addExpression(AbstractExpression $expression): self
    {
        $this->expressions[] = $expression;
        return $this;
    }

    /**
     * @param array<string, string>|null $fields
     * @return self
     */
    public function Select(?array $fields = null): self
    {
        return $this->addExpression(new Select($fields));
    }

    public function From(string $table, string $alias = 't'): self
    {
        return $this->addExpression(new From($table, $alias));
    }
}