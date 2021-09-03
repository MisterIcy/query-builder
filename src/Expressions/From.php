<?php

namespace MisterIcy\QueryBuilder\Expressions;

class From extends AbstractExpression
{
    private string $table;
    private string $alias;

    public function __construct(string $table, string $alias)
    {
        parent::__construct(90);
        $this->table = $table;
        $this->alias = $alias;
    }

    public function __toString(): string
    {
        return sprintf('FROM `%s` `%s`', $this->table, $this->alias);
    }
}