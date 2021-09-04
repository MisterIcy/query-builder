<?php

namespace MisterIcy\QueryBuilder\Expressions\Join;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;

final class LeftJoin extends JoinExpression
{
    public function __construct(string $table, AbstractOperation $joinOn, bool $outer = false, string $alias = 't')
    {
        $this->type = self::LEFT_JOIN;
        if ($outer) {
            $this->type .= ' ' . self::OUTER_JOIN;
        }
        parent::__construct($table, $joinOn, $alias);
    }
}