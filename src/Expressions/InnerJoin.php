<?php

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;

final class InnerJoin extends JoinExpression
{
    public function __construct(string $table, AbstractOperation $joinOn, string $alias = 't')
    {
        $this->type = 'INNER';
        parent::__construct($table, $joinOn, $alias);
    }
}
