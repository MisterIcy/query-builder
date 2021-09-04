<?php

namespace MisterIcy\QueryBuilder\Expressions\Join;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;

final class InnerJoin extends JoinExpression
{
    public function __construct(string $table, AbstractOperation $joinOn, string $alias = 't')
    {
        $this->type = self::INNER_JOIN;
        parent::__construct($table, $joinOn, $alias);
    }
}
