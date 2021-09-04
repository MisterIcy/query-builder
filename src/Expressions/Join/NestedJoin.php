<?php

namespace MisterIcy\QueryBuilder\Expressions\Join;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;
use MisterIcy\QueryBuilder\Operations\Nop;

class NestedJoin extends JoinExpression
{
    /**
     * @var JoinExpression[]
     */
    private array $joins;
    private bool $outer;

    /**
     * @param string $table
     * @param JoinExpression[] $joins
     * @param string $alias
     */
    public function __construct(
        string $table,
        AbstractOperation $joinOn,
        array $joins,
        string $alias = 't',
        string $type = '',
        bool $outer = false
    ) {
        parent::__construct($table, $joinOn, $alias);
        $this->joins = $joins;
        $this->type = $type;
        $this->outer = $outer;
    }

    public function __toString(): string
    {
        $builder = sprintf('%s%s JOIN', $this->type, ($this->outer) ? ' ' . self::OUTER_JOIN : '');
        $builder = ltrim($builder);

        $builder .= sprintf(' %s`%s` `%s`', $this->preSeparator, $this->table, $this->alias);

        foreach ($this->joins as $joinExpression) {
            $builder .= sprintf(
                ' %s JOIN `%s` `%s`',
                $joinExpression->type,
                $joinExpression->table,
                $joinExpression->alias
            );
        }
        $builder .= sprintf('%s ON %s', $this->postSeparator, $this->preSeparator);
        $builder .= $this->joinOn;

        foreach ($this->joins as $joinExpression) {
            $builder .= sprintf(' AND %s ', $joinExpression->joinOn);
        }

        $builder = rtrim($builder, ' AND ');

        $builder .= $this->postSeparator;
        return $builder;
    }
}
