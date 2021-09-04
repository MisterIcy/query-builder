<?php

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;

final class RightJoin extends JoinExpression
{
    public function __construct(string $table, AbstractOperation $joinOn, bool $outer = false, string $alias = 't')
    {
        $this->type = 'RIGHT';
        if ($outer) {
            $this->type .= ' OUTER';
        }
        parent::__construct($table, $joinOn, $alias);
    }
}