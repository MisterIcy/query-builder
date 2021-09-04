<?php

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;

final class LeftJoin extends JoinExpression
{
    public function __construct(string $table, AbstractOperation $joinOn, bool $outer = false, string $alias = 't')
    {
        $this->type = 'LEFT';
        if ($outer) {
            $this->type .= ' OUTER';
        }
        parent::__construct($table, $joinOn, $alias);
    }
}