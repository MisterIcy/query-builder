<?php

namespace MisterIcy\QueryBuilder\Expressions\Join;

use MisterIcy\QueryBuilder\Expressions\AbstractExpression;
use MisterIcy\QueryBuilder\Operations\AbstractOperation;

class JoinExpression extends AbstractExpression
{
    public const INNER_JOIN = 'INNER';
    public const LEFT_JOIN = 'LEFT';
    public const OUTER_JOIN = 'OUTER';
    public const RIGHT_JOIN = 'RIGHT';

    protected string $table;
    protected AbstractOperation $joinOn;
    protected string $alias;

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