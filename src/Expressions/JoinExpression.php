<?php

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;

abstract class JoinExpression extends AbstractExpression
{
    private string $table;
    private AbstractOperation $joinOn;
    private string $alias;

    protected string $type = '';

    public function __construct(
        string $table,
        AbstractOperation $joinOn,
        string $alias = 't'
    )
    {
        parent::__construct(self::PRIORITY_JOIN);
        $this->table = $table;
        $this->joinOn = $joinOn;
        $this->alias = $alias;
    }
    public function __toString(): string
    {
        return sprintf(
            '%s JOIN `%s` `%s` ON %s',
            $this->type,
            $this->table,
            $this->alias,
            strval($this->joinOn)
        );
    }
}